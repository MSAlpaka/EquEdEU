<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Domain\Service\ApiResponseServiceInterface;
use Equed\EquedLms\Domain\Service\AppSyncServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\EquedLms\Controller\Api\BaseApiController;

/**
 * API controller for queueing and fetching app sync data.
 *
 * Human-readable messages are translated via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <app_sync> feature toggle.
 */
final class AppSyncController extends BaseApiController
{
    public function __construct(
        private readonly AppSyncServiceInterface $appSyncService,
        ConfigurationServiceInterface $configurationService,
        ApiResponseServiceInterface $apiResponseService,
        GptTranslationServiceInterface $translationService,
    ) {
        parent::__construct($configurationService, $apiResponseService, $translationService);
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
        if (($check = $this->requireFeature('app_sync')) !== null) {
            return $check;
        }

        $userId = $this->getCurrentUserId($request);
        if ($userId === null) {
            return $this->jsonError('api.sync.queue.unauthorized', JsonResponse::HTTP_UNAUTHORIZED);
        }

        $body    = (array) $request->getParsedBody();
        $type    = isset($body['type']) ? (string) $body['type'] : '';
        $payload = $body['payload'] ?? null;

        if ($type === '' || !is_array($payload)) {
            return $this->jsonError('api.sync.queue.invalidData', JsonResponse::HTTP_BAD_REQUEST);
        }

        $this->appSyncService->queueData($userId, $type, $payload);

        return $this->jsonSuccess([], 'api.sync.queue.processed');
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
        if (($check = $this->requireFeature('app_sync')) !== null) {
            return $check;
        }

        $userId = $this->getCurrentUserId($request);
        if ($userId === null) {
            return $this->jsonError('api.sync.fetch.unauthorized', JsonResponse::HTTP_UNAUTHORIZED);
        }

        $records = $this->appSyncService->fetchPending($userId);

        return $this->jsonSuccess([
            'syncs' => $records,
        ]);
    }
}
// EOF
