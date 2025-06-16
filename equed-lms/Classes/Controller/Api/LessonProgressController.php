<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\ApiResponseServiceInterface;
use Equed\EquedLms\Domain\Service\LessonProgressServiceInterface;
use Equed\EquedLms\Controller\Api\BaseApiController;

/**
 * API controller for lesson progress: get and set progress for lessons.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <lesson_progress_api> feature toggle.
 */
final class LessonProgressController extends BaseApiController
{
    public function __construct(
        private readonly LessonProgressServiceInterface $lessonProgressService,
        ConfigurationServiceInterface $configurationService,
        ApiResponseServiceInterface $apiResponseService,
        GptTranslationServiceInterface $translationService,
    ) {
        parent::__construct($configurationService, $apiResponseService, $translationService);
    }

    /**
     * Returns the progress for a lesson for the authenticated user.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     */
    public function getAction(ServerRequestInterface $request): JsonResponse
    {
        if (($check = $this->requireFeature('lesson_progress_api')) !== null) {
            return $check;
        }

        $userId = $this->getCurrentUserId($request);
        if ($userId === null) {
            return $this->jsonError('api.lessonProgress.unauthorized', JsonResponse::HTTP_UNAUTHORIZED);
        }

        $params = $request->getQueryParams();
        $lessonId = isset($params['lessonId']) ? (int)$params['lessonId'] : 0;
        if ($lessonId <= 0) {
            return $this->jsonError('api.lessonProgress.invalidLessonId', JsonResponse::HTTP_BAD_REQUEST);
        }

        $progress = $this->lessonProgressService->getProgress($userId, $lessonId);

        return $this->jsonSuccess(['progress' => $progress]);
    }

    /**
     * Sets the progress for a lesson for the authenticated user.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     */
    public function setAction(ServerRequestInterface $request): JsonResponse
    {
        if (($check = $this->requireFeature('lesson_progress_api')) !== null) {
            return $check;
        }

        $userId = $this->getCurrentUserId($request);
        if ($userId === null) {
            return $this->jsonError('api.lessonProgress.unauthorized', JsonResponse::HTTP_UNAUTHORIZED);
        }

        $body = (array)$request->getParsedBody();
        $lessonId = isset($body['lessonId']) ? (int)$body['lessonId'] : 0;
        $completed = isset($body['completed']) ? (bool)$body['completed'] : null;
        if ($lessonId <= 0 || $completed === null) {
            return $this->jsonError('api.lessonProgress.invalidInput', JsonResponse::HTTP_BAD_REQUEST);
        }

        $this->lessonProgressService->setProgress($userId, $lessonId, $completed);

        return $this->jsonSuccess([
            'message' => $this->translationService->translate('api.lessonProgress.saved'),
        ]);
    }
}
// End of file
