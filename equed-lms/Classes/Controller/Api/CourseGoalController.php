<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Controller\Api\BaseApiController;
use Equed\EquedLms\Domain\Service\ApiResponseServiceInterface;
use Equed\EquedLms\Domain\Service\CourseGoalServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;

/**
 * API controller for retrieving course goals.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <course_goal_api> feature toggle.
 */
final class CourseGoalController extends BaseApiController
{
    public function __construct(
        private readonly CourseGoalServiceInterface $courseGoalService,
        ConfigurationServiceInterface $configurationService,
        ApiResponseServiceInterface $apiResponseService,
        GptTranslationServiceInterface $translationService,
    ) {
        parent::__construct($configurationService, $apiResponseService, $translationService);
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
        if (($check = $this->requireFeature('course_goal_api')) !== null) {
            return $check;
        }

        $goals = $this->courseGoalService->getAllCourseGoals();

        return $this->jsonSuccess([
            'goals' => $goals,
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
        if (($check = $this->requireFeature('course_goal_api')) !== null) {
            return $check;
        }

        $params = $request->getQueryParams();
        $programId = isset($params['programId']) ? (int)$params['programId'] : 0;
        if ($programId <= 0) {
            return $this->jsonError('api.courseGoal.invalidProgramId', JsonResponse::HTTP_BAD_REQUEST);
        }

        $goals = $this->courseGoalService->getGoalsForProgram($programId);

        return $this->jsonSuccess([
            'programId' => $programId,
            'goals'     => $goals,
        ]);
    }
}
// EOF
