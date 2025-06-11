<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Repository\LessonRepositoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;

/**
 * API controller for fetching lesson details.
 *
 * Human-readable messages are translated via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <lesson_api> feature toggle.
 */
final class AppLessonController
{
    public function __construct(
        private readonly LessonRepositoryInterface      $lessonRepository,
        private readonly ConfigurationServiceInterface  $configurationService,
        private readonly GptTranslationServiceInterface $translationService
    ) {
    }

    /**
     * Returns lesson details as JSON.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function listAction(ServerRequestInterface $request): JsonResponse
    {
        if (!$this->configurationService->isFeatureEnabled('lesson_api')) {
            return new JsonResponse([
                'error' => $this->translationService->translate('api.lesson.disabled'),
            ], 403);
        }

        $queryParams = $request->getQueryParams();
        $lessonId = isset($queryParams['lessonId']) ? (int)$queryParams['lessonId'] : null;
        if ($lessonId === null || $lessonId <= 0) {
            return new JsonResponse([
                'error' => $this->translationService->translate('api.lesson.missingLessonId'),
            ], 400);
        }

        $lesson = $this->lessonRepository->findByUid($lessonId);
        if ($lesson === null) {
            return new JsonResponse([
                'error' => $this->translationService->translate('api.lesson.notFound'),
            ], 404);
        }

        $data = [
            'uid'         => $lesson->getUid(),
            'title'       => $lesson->getTitle(),
            'description' => $lesson->getDescription(),
            'content'     => $lesson->getContent(),
            'downloadUrl' => $lesson->getDownloadUrl(),
        ];

        return new JsonResponse([
            'status' => 'success',
            'lesson' => $data,
        ]);
    }
}
// EOF
