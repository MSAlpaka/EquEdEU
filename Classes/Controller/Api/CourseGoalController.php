<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\CourseGoalServiceInterface;
use TYPO3\CMS\Core\Http\JsonResponse;

/**
 * API controller for retrieving course goals.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <course_goal_api> feature toggle.
 */
final class CourseGoalController
{
    public function __construct(
        private readonly CourseGoalServiceInterface      $courseGoalService,
        private readonly ConfigurationServiceInterface   $configurationService,
        private readonly GptTranslationServiceInterface  $translationService
    ) {
    }

    /**
     * Returns all course goals.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function listAllAction(ServerRequestInterface $request): JsonResponse
    {
        if (! $this->configurationService->isFeatureEnabled('course_goal_api')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.courseGoal.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $goals = $this->courseGoalService->getAllCourseGoals();

        return new JsonResponse([
            'status' => 'success',
            'goals'  => $goals,
        ]);
    }

    /**
     * Returns course goals for a specific program.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function listByProgramAction(ServerRequestInterface $request): JsonResponse
    {
        if (! $this->configurationService->isFeatureEnabled('course_goal_api')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.courseGoal.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $params = $request->getQueryParams();
        $programId = isset($params['programId']) ? (int)$params['programId'] : 0;
        if ($programId <= 0) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.courseGoal.invalidProgramId')],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $goals = $this->courseGoalService->getGoalsForProgram($programId);

        return new JsonResponse([
            'status'    => 'success',
            'programId' => $programId,
            'goals'     => $goals,
        ]);
    }
}
// EOF
