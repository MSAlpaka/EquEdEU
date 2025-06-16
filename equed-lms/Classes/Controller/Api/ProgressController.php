<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Service\ProgressServiceInterface;
use Equed\EquedLms\Controller\Api\BaseApiController;
use Equed\EquedLms\Domain\Service\ApiResponseServiceInterface;

/**
 * API controller for calculating course progress.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <progress_api> feature toggle.
 */
final class ProgressController extends BaseApiController
{
    public function __construct(
        private readonly ProgressServiceInterface $progressService,
        ConfigurationServiceInterface $configurationService,
        ApiResponseServiceInterface $apiResponseService,
        GptTranslationServiceInterface $translationService,
    ) {
    }

    /**
     * Returns progress for a given user course record.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     */
    public function getCourseProgressAction(ServerRequestInterface $request): JsonResponse
    {
        if (($check = $this->requireFeature('progress_api')) !== null) {
            return $check;
        }

        $userId = $this->getCurrentUserId($request);
        if ($userId === null) {
            return $this->jsonError('api.progress.unauthorized', JsonResponse::HTTP_UNAUTHORIZED);
        }

        $params   = $request->getQueryParams();
        $recordId = isset($params['recordId']) ? (int)$params['recordId'] : 0;
        if ($recordId <= 0) {
            return $this->jsonError('api.progress.invalidRecordId', JsonResponse::HTTP_BAD_REQUEST);
        }

        $progress = $this->progressService->getCourseProgress($userId, $recordId);

        return $this->jsonSuccess(['progress' => $progress]);
    }
}
