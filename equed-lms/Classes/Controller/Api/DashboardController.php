<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\DashboardServiceInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * API controller for dashboard data: progress, badges, open tasks, recommendations, and next steps.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <dashboard_api> feature toggle.
 */
final class DashboardController extends ActionController
{
    public function __construct(
        private readonly DashboardServiceInterface         $dashboardService,
        private readonly ConfigurationServiceInterface     $configurationService,
        private readonly GptTranslationServiceInterface    $translationService,
    ) {
        parent::__construct();
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
        if (! $this->configurationService->isFeatureEnabled('dashboard_api')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.dashboard.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $userContext = $request->getAttribute('user');
        $userId = is_array($userContext) && isset($userContext['uid'])
            ? (int)$userContext['uid']
            : null;

        if ($userId === null) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.dashboard.unauthorized')],
                JsonResponse::HTTP_UNAUTHORIZED
            );
        }

        $progress             = $this->dashboardService->getProgress($userId);
        $badges               = $this->dashboardService->getBadges($userId);
        $openTasks            = $this->dashboardService->getOpenTasks($userId);
        $recommendedCourses   = $this->dashboardService->getRecommendedCourses($userId);
        $nextSteps            = $this->dashboardService->getNextSteps($userId);

        return new JsonResponse([
            'status'              => 'success',
            'progress'            => $progress,
            'badges'              => $badges,
            'openTasks'           => $openTasks,
            'recommendedCourses'  => $recommendedCourses,
            'nextSteps'           => $nextSteps,
        ]);
    }
}
// End of file
