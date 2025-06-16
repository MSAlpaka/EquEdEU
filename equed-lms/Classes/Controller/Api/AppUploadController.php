<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\ApiResponseServiceInterface;
use Equed\EquedLms\Domain\Service\MediaUploadServiceInterface;
use Equed\EquedLms\Dto\UploadFileRequest;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\EquedLms\Controller\Api\BaseApiController;

/**
 * API controller for handling file uploads from the mobile app.
 *
 * Human-readable messages are translated via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <app_upload> feature toggle.
 */
final class AppUploadController extends BaseApiController
{
    public function __construct(
        private readonly MediaUploadServiceInterface $mediaUploadService,
        ConfigurationServiceInterface $configurationService,
        ApiResponseServiceInterface $apiResponseService,
        GptTranslationServiceInterface $translationService,
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
        if (($check = $this->requireFeature('app_upload')) !== null) {
            return $check;
        }

        try {
            $dto = UploadFileRequest::fromRequest($request);
        } catch (\InvalidArgumentException $e) {
            return $this->jsonError('api.upload.invalidFile', JsonResponse::HTTP_BAD_REQUEST);
        }

        if ($dto->getUserId() <= 0) {
            return $this->jsonError('api.upload.unauthorized', JsonResponse::HTTP_UNAUTHORIZED);
        }

        $result = $this->mediaUploadService->upload($dto);

        if ($result->hasError()) {
            return $this->jsonError('api.upload.invalidFile', JsonResponse::HTTP_BAD_REQUEST);
        }

        return $this->jsonSuccess([
            'file' => $result->getFileReference(),
        ]);
    }
}
