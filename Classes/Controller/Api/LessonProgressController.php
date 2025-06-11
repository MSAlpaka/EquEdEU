<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Context\Context;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\LessonProgressServiceInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * API controller for lesson progress: get and set progress for lessons.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <lesson_progress_api> feature toggle.
 */
final class LessonProgressController extends ActionController
{
    public function __construct(
        private readonly LessonProgressServiceInterface  $lessonProgressService,
        private readonly ConfigurationServiceInterface   $configurationService,
        private readonly GptTranslationServiceInterface $translationService,
        private readonly Context                         $context
    ) {
        parent::__construct();
    }

    /**
     * Returns the progress for a lesson for the authenticated user.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     */
    public function getAction(ServerRequestInterface $request): JsonResponse
    {
        if (! $this->configurationService->isFeatureEnabled('lesson_progress_api')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.lessonProgress.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $user = $this->context->getAspect('frontend.user')->get('user');
        $userId = is_array($user) && isset($user['uid']) ? (int)$user['uid'] : null;
        if ($userId === null) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.lessonProgress.unauthorized')],
                JsonResponse::HTTP_UNAUTHORIZED
            );
        }

        $params = $request->getQueryParams();
        $lessonId = isset($params['lessonId']) ? (int)$params['lessonId'] : 0;
        if ($lessonId <= 0) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.lessonProgress.invalidLessonId')],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $progress = $this->lessonProgressService->getProgress($userId, $lessonId);

        return new JsonResponse([
            'status'   => 'success',
            'progress' => $progress,
        ]);
    }

    /**
     * Sets the progress for a lesson for the authenticated user.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     */
    public function setAction(ServerRequestInterface $request): JsonResponse
    {
        if (! $this->configurationService->isFeatureEnabled('lesson_progress_api')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.lessonProgress.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $user = $this->context->getAspect('frontend.user')->get('user');
        $userId = is_array($user) && isset($user['uid']) ? (int)$user['uid'] : null;
        if ($userId === null) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.lessonProgress.unauthorized')],
                JsonResponse::HTTP_UNAUTHORIZED
            );
        }

        $body = (array)$request->getParsedBody();
        $lessonId = isset($body['lessonId']) ? (int)$body['lessonId'] : 0;
        $completed = isset($body['completed']) ? (bool)$body['completed'] : null;
        if ($lessonId <= 0 || $completed === null) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.lessonProgress.invalidInput')],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $this->lessonProgressService->setProgress($userId, $lessonId, $completed);

        return new JsonResponse([
            'status'  => 'success',
            'message' => $this->translationService->translate('api.lessonProgress.saved'),
        ]);
    }
}
// End of file
