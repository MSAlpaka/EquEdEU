<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\ApiResponseServiceInterface;
use Equed\EquedLms\Service\LessonServiceInterface;
use Equed\EquedLms\Controller\Api\BaseApiController;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;

/**
 * API controller for fetching lesson details.
 *
 * Human-readable messages are translated via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <lesson_api> feature toggle.
 */
final class AppLessonController extends BaseApiController
{
    public function __construct(
        private readonly LessonServiceInterface        $lessonService,
        ConfigurationServiceInterface                 $configurationService,
        ApiResponseServiceInterface                   $apiResponseService,
        GptTranslationServiceInterface                $translationService,
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
        if (($check = $this->requireFeature('lesson_api')) !== null) {
            return $check;
        }

        $queryParams = $request->getQueryParams();
        $lessonId = isset($queryParams['lessonId']) ? (int)$queryParams['lessonId'] : null;
        if ($lessonId === null || $lessonId <= 0) {
            return $this->jsonError('api.lesson.missingLessonId', JsonResponse::HTTP_BAD_REQUEST);
        }

        $data = $this->lessonService->getLessonDtoById($lessonId);
        if ($data === null) {
            return $this->jsonError('api.lesson.notFound', JsonResponse::HTTP_NOT_FOUND);
        }
        return $this->jsonSuccess(['lesson' => $data]);
    }
}
