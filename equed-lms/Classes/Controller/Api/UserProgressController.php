<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Equed\EquedLms\Service\ProgressServiceInterface;
use Equed\EquedLms\Controller\Api\BaseApiController;
use Equed\EquedLms\Domain\Service\ApiResponseServiceInterface;
use Equed\Core\Service\ConfigurationServiceInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\EquedLms\Service\GptTranslationServiceInterface;

/**
 * UserProgressController
 *
 * Provides endpoints to retrieve a user's progress across courses and lessons.
 */
final class UserProgressController extends BaseApiController
{

    public function __construct(
        private readonly ProgressServiceInterface $progressService,
        ConfigurationServiceInterface $configurationService,
        ApiResponseServiceInterface $apiResponseService,
        GptTranslationServiceInterface $translationService,
    ) {
        parent::__construct($configurationService, $apiResponseService, $translationService);
    }

    /**
     * GET /api/user/progress
     */
    public function showAction(ServerRequestInterface $request): JsonResponse
    {
        if (($check = $this->requireFeature('progress_api')) !== null) {
            return $check;
        }

        $userId = $this->getCurrentUserId($request);
        if ($userId === null) {
            return $this->jsonError('api.userProgress.unauthorized', JsonResponse::HTTP_UNAUTHORIZED);
        }

        $data = $this->progressService->getProgressDataForUser($userId);

        return $this->jsonSuccess(['progress' => $data]);
    }

    /**
     * GET /api/user/progress/course?recordId={id}
     */
    public function courseAction(ServerRequestInterface $request): JsonResponse
    {
        if (($check = $this->requireFeature('progress_api')) !== null) {
            return $check;
        }

        $userId = $this->getCurrentUserId($request);
        $params = $request->getQueryParams();
        $recordId = (int)($params['recordId'] ?? 0);

        if ($userId === null || $recordId <= 0) {
            return $this->jsonError('api.userProgress.invalidParameters', JsonResponse::HTTP_BAD_REQUEST);
        }

        $data = $this->progressService->getCourseProgress($userId, $recordId);

        return $this->jsonSuccess(['progress' => $data]);
    }
}
// EOF
