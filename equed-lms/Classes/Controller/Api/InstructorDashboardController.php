<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\InstructorDashboardServiceInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * API controller for instructor dashboard data:
 * - own course instances
 * - own participants (user course records)
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <instructor_dashboard_api> feature toggle.
 */
final class InstructorDashboardController extends ActionController
{
    public function __construct(
        private readonly InstructorDashboardServiceInterface $dashboardService,
        private readonly ConfigurationServiceInterface       $configurationService,
        private readonly GptTranslationServiceInterface      $translationService,
    ) {
        parent::__construct();
    }

    /**
     * Returns instructor dashboard data: course instances and participants.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function indexAction(ServerRequestInterface $request): JsonResponse
    {
        if (! $this->configurationService->isFeatureEnabled('instructor_dashboard_api')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.instructorDashboard.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $user = $request->getAttribute('user');
        $instructorId = is_array($user) && isset($user['uid']) ? (int)$user['uid'] : null;
        if ($instructorId === null || ! $this->dashboardService->isInstructor($instructorId)) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.instructorDashboard.accessDenied')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $courseInstances = $this->dashboardService->getInstructorInstances($instructorId);
        $participants     = $this->dashboardService->getInstructorParticipants($instructorId);

        return new JsonResponse([
            'status'           => 'success',
            'courseInstances'  => $courseInstances,
            'participants'     => $participants,
        ]);
    }
}
// End of file
