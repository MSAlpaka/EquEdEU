<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\CourseOverviewServiceInterface;

/**
 * API controller for providing course overview data:
 * available programs, active instances, and user's courses.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <course_overview_api> feature toggle.
 */
final class CourseOverviewController
{
    public function __construct(
        private readonly CourseOverviewServiceInterface    $overviewService,
        private readonly ConfigurationServiceInterface     $configurationService,
        private readonly GptTranslationServiceInterface    $translationService,
    ) {
    }

    /**
     * Returns course overview data as JSON.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function indexAction(ServerRequestInterface $request): JsonResponse
    {
        if (! $this->configurationService->isFeatureEnabled('course_overview_api')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.courseOverview.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $user = $request->getAttribute('user');
        $userId = is_array($user) && isset($user['uid'])
            ? (int)$user['uid']
            : null;

        if ($userId === null) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.courseOverview.unauthorized')],
                JsonResponse::HTTP_UNAUTHORIZED
            );
        }

        $availablePrograms = $this->overviewService->getAvailablePrograms();
        $activeInstances   = $this->overviewService->getActiveInstances();
        $myCourses         = $this->overviewService->getMyCourses($userId);

        return new JsonResponse([
            'status'            => 'success',
            'availablePrograms' => $availablePrograms,
            'activeInstances'   => $activeInstances,
            'myCourses'         => $myCourses,
        ]);
    }
}
// End of file
