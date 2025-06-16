<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Domain\Service\ApiResponseServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\InstructorDashboardServiceInterface;
use Equed\EquedLms\Controller\Api\BaseApiController;

/**
 * API controller for instructor dashboard data:
 * - own course instances
 * - own participants (user course records)
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <instructor_dashboard_api> feature toggle.
 */
final class InstructorDashboardController extends BaseApiController
{
    public function __construct(
        private readonly InstructorDashboardServiceInterface $dashboardService,
        ConfigurationServiceInterface       $configurationService,
        ApiResponseServiceInterface         $apiResponseService,
        GptTranslationServiceInterface      $translationService,
    ) {
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
        if (($check = $this->requireFeature('instructor_dashboard_api')) !== null) {
            return $check;
        }
        $instructorId = $this->getCurrentUserId($request);
        if ($instructorId === null || ! $this->dashboardService->isInstructor($instructorId)) {
            return $this->jsonError('api.instructorDashboard.accessDenied', JsonResponse::HTTP_FORBIDDEN);
        }

        $courseInstances = $this->dashboardService->getInstructorInstances($instructorId);
        $participants     = $this->dashboardService->getInstructorParticipants($instructorId);

        return $this->jsonSuccess([
            'courseInstances' => $courseInstances,
            'participants'    => $participants,
        ]);
    }
}
