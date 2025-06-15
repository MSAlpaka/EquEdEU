<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Service\LogService;
use Equed\EquedLms\Domain\Service\MediaUploadServiceInterface;
use TYPO3\CMS\Core\Resource\Exception\FileOperationErrorException;
use TYPO3\CMS\Core\Resource\ResourceStorage;
use TYPO3\CMS\Core\Resource\StorageRepository;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\StringUtility;
use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Dto\UploadFileRequest;
use Equed\EquedLms\Dto\UploadFileResult;

/**
 * Service to securely handle media file uploads.
 */
final class MediaUploadService implements MediaUploadServiceInterface
{
    private const ALLOWED_MIME_TYPES = [
        'image/jpeg',
        'image/png',
        'application/pdf',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' // DOCX
    ];

    public function __construct(
        private readonly StorageRepository $storageRepository,
        private readonly LogService $logService,
        private readonly ResourceFactory $resourceFactory,
        private readonly int $maxFileSize = 5242880
    ) {
    }

    /**
     * Handles an upload request and stores the file in the default storage.
     *
     * @param array $uploadedFile Superglobal-like $_FILES['file']
     * @param FrontendUser $user Authenticated user
     * @return FileReference|null
     */
    public function handleUpload(array $uploadedFile, FrontendUser $user): ?FileReference
    {
        if (!isset($uploadedFile['tmp_name'], $uploadedFile['name'], $uploadedFile['type'])) {
            $this->logService->logWarning('Incomplete upload structure.');
            return null;
        }

        if (!in_array($uploadedFile['type'], self::ALLOWED_MIME_TYPES, true)) {
            $this->logService->logWarning('Upload rejected due to MIME type', ['type' => $uploadedFile['type']]);
            return null;
        }

        $size = @filesize($uploadedFile['tmp_name']);
        if ($size === false || $size > $this->maxFileSize) {
            $this->logService->logWarning('Upload rejected due to file size', ['size' => $size]);
            return null;
        }

        $storage = $this->storageRepository->findDefaultStorage();
        if (!$storage instanceof ResourceStorage) {
            $this->logService->logError('No valid storage available.');
            return null;
        }

        try {
            $file = $storage->addFile(
                $uploadedFile['tmp_name'],
                $storage->getRootLevelFolder(),
                $uploadedFile['name']
            );

            $coreRef = $this->resourceFactory->createFileReferenceObject([
                    'uid_local'   => $file->getUid(),
                    'uid_foreign' => StringUtility::getUniqueId('NEW_'),
                    'uid'         => StringUtility::getUniqueId('NEW_'),
                ]);

            $fileRef = new FileReference();
            $fileRef->setOriginalResource($coreRef);
            $fileRef->setTitle($uploadedFile['name']);
            $fileRef->setDescription('Uploaded by user ID: ' . $user->getUid());

            return $fileRef;
        } catch (FileOperationErrorException $e) {
            $this->logService->logError('Upload failed', ['exception' => $e]);
            return null;
        }
    }

    public function upload(UploadFileRequest $request): UploadFileResult
    {
        $file = $request->getFile();
        $tmpPath = $file->getStream()->getMetadata('uri');
        if (!is_string($tmpPath)) {
            return new UploadFileResult(null, 'invalid_file');
        }

        $payload = [
            'tmp_name' => $tmpPath,
            'name' => $file->getClientFilename() ?? 'upload',
            'type' => $file->getClientMediaType() ?? ''
        ];

        $user = new FrontendUser();
        if (method_exists($user, 'setUid')) {
            $user->setUid($request->getUserId());
        }

        $result = $this->handleUpload($payload, $user);

        if ($result === null) {
            return new UploadFileResult(null, 'upload_failed');
        }

        return new UploadFileResult($result);
    }
}
