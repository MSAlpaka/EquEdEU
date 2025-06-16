<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\EquedLms\Controller\Api\BaseApiController;
use Equed\EquedLms\Domain\Service\ApiResponseServiceInterface;
use Equed\EquedLms\Service\LessonProgressSyncService;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;

/**
 * API controller for exporting user-specific lesson progress.
 *
 * Protected by <lesson_sync_api> feature toggle.
 */
final class LessonController extends BaseApiController
{
    public function __construct(
        private readonly LessonProgressSyncService $progressService,
        ConfigurationServiceInterface $configurationService,
        ApiResponseServiceInterface $apiResponseService,
        GptTranslationServiceInterface $translationService,
    ) {
        parent::__construct($configurationService, $apiResponseService, $translationService);
    }

    public function exportAction(ServerRequestInterface $request): JsonResponse
    {
        if (($check = $this->requireFeature('lesson_sync_api')) !== null) {
            return $check;
        }

        $userId = $this->getCurrentUserId($request);

        if ($userId === null) {
            return $this->jsonError('api.lessonSync.unauthorized', JsonResponse::HTTP_UNAUTHORIZED);
        }

        try {
            $progress = $this->progressService->exportForApp($userId);

            return $this->jsonSuccess([
                'progress' => $progress,
            ]);
        } catch (\Throwable $e) {
            return $this->jsonError('api.lessonSync.failed', JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
