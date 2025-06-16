<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Domain\Service\ApiResponseServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Repository\UserRepositoryInterface;
use Equed\EquedLms\Domain\Service\DashboardServiceInterface;
use Equed\EquedLms\Controller\Api\BaseApiController;

/**
 * API controller for dashboard data: progress, badges, open tasks, recommendations, and next steps.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <dashboard_api> feature toggle.
 */
final class DashboardController extends BaseApiController
{
    public function __construct(
        private readonly DashboardServiceInterface $dashboardService,
        private readonly UserRepositoryInterface   $userRepository,
        ConfigurationServiceInterface              $configurationService,
        ApiResponseServiceInterface                $apiResponseService,
        GptTranslationServiceInterface             $translationService,
    ) {
        parent::__construct($configurationService, $apiResponseService, $translationService);
    }

    /**
     * Returns dashboard data for the authenticated user.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function showAction(ServerRequestInterface $request): JsonResponse
    {
        if (($check = $this->requireFeature('dashboard_api')) !== null) {
            return $check;
        }

        $userId = $this->getCurrentUserId($request);

        if ($userId === null) {
            return $this->jsonError('api.dashboard.unauthorized', JsonResponse::HTTP_UNAUTHORIZED);
        }

        $user = $this->userRepository->findByUid($userId);
        if ($user === null) {
            return $this->jsonError('api.dashboard.userNotFound', JsonResponse::HTTP_NOT_FOUND);
        }

        $data = $this->dashboardService->getDashboardDataForUser($user);

        return $this->jsonSuccess([
            'data' => $data,
        ]);
    }
}
// End of file
