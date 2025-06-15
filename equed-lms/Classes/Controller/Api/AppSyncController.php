<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\AppSyncServiceInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;

/**
 * API controller for queueing and fetching app sync data.
 *
 * Human-readable messages are translated via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <app_sync> feature toggle.
 */
final class AppSyncController
{
    public function __construct(
        private readonly AppSyncServiceInterface         $appSyncService,
        private readonly ConfigurationServiceInterface   $configurationService,
        private readonly GptTranslationServiceInterface  $translationService
    ) {
    }

    /**
     * Queues payload for later app sync.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function queueDataAction(ServerRequestInterface $request): JsonResponse
    {
        if (!$this->configurationService->isFeatureEnabled('app_sync')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.sync.queue.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $user = $request->getAttribute('user');
        $userId = is_array($user) && isset($user['uid']) ? (int)$user['uid'] : null;
        if ($userId === null) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.sync.queue.unauthorized')],
                JsonResponse::HTTP_UNAUTHORIZED
            );
        }

        $body = (array)$request->getParsedBody();
        $type = isset($body['type']) ? (string)$body['type'] : '';
        $payload = $body['payload'] ?? null;

        if ($type === '' || !is_array($payload)) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.sync.queue.invalidData')],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $this->appSyncService->queueData($userId, $type, $payload);

        return new JsonResponse([
            'status'  => 'success',
            'message' => $this->translationService->translate('api.sync.queue.processed'),
        ]);
    }

    /**
     * Returns pending sync entries for the authenticated user.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function fetchPendingSyncsAction(ServerRequestInterface $request): JsonResponse
    {
        if (!$this->configurationService->isFeatureEnabled('app_sync')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.sync.fetch.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $user = $request->getAttribute('user');
        $userId = is_array($user) && isset($user['uid']) ? (int)$user['uid'] : null;
        if ($userId === null) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.sync.fetch.unauthorized')],
                JsonResponse::HTTP_UNAUTHORIZED
            );
        }

        $records = $this->appSyncService->fetchPending($userId);

        return new JsonResponse([
            'status' => 'success',
            'syncs'  => $records,
        ]);
    }
}
// EOF
