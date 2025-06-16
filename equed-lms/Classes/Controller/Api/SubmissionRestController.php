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
        parent::__construct($configurationService, $apiResponseService, $translationService);
    }

    public function exportAction(ServerRequestInterface $request): JsonResponse
    {
        $params  = $request->getQueryParams();
        $userId = isset($params['userId']) ? (int) $params['userId'] : null;

        if ($userId === null) {
            $userId = $this->getCurrentUserId($request);
        }

        if ($userId === null || $userId <= 0) {
            return $this->jsonError('api.submission.invalidUser', JsonResponse::HTTP_BAD_REQUEST);
        }

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
        $payload = (array) $request->getParsedBody();

        if (!isset($payload['userId']) || (int) $payload['userId'] <= 0) {
            $userId = $this->getCurrentUserId($request);
            if ($userId !== null) {
                $payload['userId'] = $userId;
            }
        }

        if (empty($payload['userId']) || !isset($payload['submission'])) {
            return $this->jsonError('api.submission.invalidPayload', JsonResponse::HTTP_BAD_REQUEST);
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
