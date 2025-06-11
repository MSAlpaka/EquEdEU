<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\MediaUploadServiceInterface;
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

        $user = $this->context->getAspect('frontend.user')->get('user');
        $userId = is_array($user) && isset($user['uid']) ? (int)$user['uid'] : null;
        if ($userId === null) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.upload.unauthorized')],
                JsonResponse::HTTP_UNAUTHORIZED
            );
        }

        $body = $request->getParsedBody() ?? [];
        $type = isset($body['type']) ? (string)$body['type'] : 'general';
        $description = isset($body['description']) ? (string)$body['description'] : '';

        $files = $request->getUploadedFiles();
        $file = $files['file'] ?? null;
        if ($file === null || $file->getError() !== \UPLOAD_ERR_OK) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.upload.invalidFile')],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $filePath = $this->mediaUploadService->upload(
            userId: $userId,
            file: $file,
            type: $type,
            description: $description
        );

        return new JsonResponse([
            'status'    => 'success',
            'file_path' => $filePath,
        ]);
    }
}
// End of file
