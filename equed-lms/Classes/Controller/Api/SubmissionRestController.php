<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Controller\Api\BaseApiController;
use Equed\EquedLms\Domain\Service\ApiResponseServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Service\SubmissionSyncService;

final class SubmissionRestController extends BaseApiController
{
    public function __construct(
        private readonly SubmissionSyncService $submissionService,
        ConfigurationServiceInterface $configurationService,
        ApiResponseServiceInterface $apiResponseService,
        GptTranslationServiceInterface $translationService,
    ) {
    }

    public function exportAction(ServerRequestInterface $request): JsonResponse
    {
        if (($check = $this->requireFeature('submission_sync_api')) !== null) {
            return $check;
        }

        $currentUserId = $this->getCurrentUserId($request);
        if ($currentUserId === null) {
            return $this->jsonError('api.submission.unauthorized', JsonResponse::HTTP_UNAUTHORIZED);
        }

        $params  = $request->getQueryParams();
        $userId  = isset($params['userId']) ? (int) $params['userId'] : $currentUserId;

        try {
            $data = $this->submissionService->exportForApp($userId);

            return $this->jsonSuccess([
                'submissions' => $data,
            ]);
        } catch (\Throwable $e) {
            return $this->jsonError('api.submission.exportFailed', JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function importAction(ServerRequestInterface $request): JsonResponse
    {
        if (($check = $this->requireFeature('submission_sync_api')) !== null) {
            return $check;
        }

        $currentUserId = $this->getCurrentUserId($request);
        if ($currentUserId === null) {
            return $this->jsonError('api.submission.unauthorized', JsonResponse::HTTP_UNAUTHORIZED);
        }

        $payload = (array) $request->getParsedBody();
        if (!isset($payload['userId']) || (int) $payload['userId'] <= 0) {
            $payload['userId'] = $currentUserId;
        }

        try {
            $submission = $this->submissionService->importFromApp($payload);

            return $this->jsonSuccess([
                'uuid' => $submission->getUuid(),
            ]);
        } catch (\Throwable $e) {
            return $this->jsonError('api.submission.importFailed', JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
