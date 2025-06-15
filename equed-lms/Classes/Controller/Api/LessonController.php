<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Equed\EquedLms\Service\LessonProgressSyncService;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;

/**
 * API controller for exporting user-specific lesson progress.
 *
 * Protected by <lesson_sync_api> feature toggle.
 */
final class LessonController extends ActionController
{
    public function __construct(
        private readonly LessonProgressSyncService $progressService,
        private readonly ConfigurationServiceInterface $configurationService,
        private readonly GptTranslationServiceInterface $translationService,
    ) {
        parent::__construct();
    }

    public function exportAction(ServerRequestInterface $request): ResponseInterface
    {
        if (! $this->configurationService->isFeatureEnabled('lesson_sync_api')) {
            return new JsonResponse([
                'error' => $this->translationService->translate('api.lessonSync.disabled'),
            ], 403);
        }

        $userContext = $request->getAttribute('user');
        $userId = is_array($userContext) && isset($userContext['uid']) ? (int)$userContext['uid'] : null;

        if ($userId === null) {
            return new JsonResponse([
                'error' => $this->translationService->translate('api.lessonSync.unauthorized'),
            ], 401);
        }

        try {
            $progress = $this->progressService->exportForApp($userId);
            return new JsonResponse([
                'status' => 'success',
                'progress' => $progress,
            ]);
        } catch (\Throwable $e) {
            return new JsonResponse([
                'error' => $this->translationService->translate('api.lessonSync.failed'),
            ], 500);
        }
    }
}
