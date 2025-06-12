<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Service\LogServiceInterface;
use Equed\EquedLms\Domain\Service\MediaUploadServiceInterface;
use TYPO3\CMS\Core\Resource\ResourceStorage;
use TYPO3\CMS\Core\Resource\StorageRepository;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\StringUtility;
use Equed\EquedLms\Domain\Model\FrontendUser;

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
        private readonly LogServiceInterface $logService,
        private readonly ResourceFactory $resourceFactory
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
        } catch (\Throwable $e) {
            $this->logService->logError('Upload failed', ['exception' => $e]);
            return null;
        }
    }
}
