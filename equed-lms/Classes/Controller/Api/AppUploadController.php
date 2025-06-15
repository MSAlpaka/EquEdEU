<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\MediaUploadServiceInterface;
use Equed\EquedLms\Dto\UploadFileRequest;
use Equed\EquedLms\Dto\UploadFileResult;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Http\JsonResponse;

/**
 * API controller for handling file uploads from the mobile app.
 *
 * Human-readable messages are translated via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <app_upload> feature toggle.
 */
final class AppUploadController
{
    public function __construct(
        private readonly MediaUploadServiceInterface     $mediaUploadService,
        private readonly ConfigurationServiceInterface   $configurationService,
        private readonly GptTranslationServiceInterface  $translationService,
        private readonly Context                         $context
    ) {
    }

    /**
     * Handles file upload, stores media, and returns JSON response.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function uploadAction(ServerRequestInterface $request): JsonResponse
    {
        if (!$this->configurationService->isFeatureEnabled('app_upload')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.upload.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        try {
            $dto = UploadFileRequest::fromRequest($request);
        } catch (\InvalidArgumentException $e) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.upload.invalidFile')],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        if ($dto->getUserId() <= 0) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.upload.unauthorized')],
                JsonResponse::HTTP_UNAUTHORIZED
            );
        }

        $result = $this->mediaUploadService->upload($dto);

        if ($result->hasError()) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.upload.invalidFile')],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        return new JsonResponse([
            'status'    => 'success',
            'file'      => $result->getFileReference(),
        ]);
    }
}
// End of file
