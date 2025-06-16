<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\EquedLms\Controller\Api\BaseApiController;
use Equed\EquedLms\Domain\Service\ApiResponseServiceInterface;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Service\SyncService;
use Equed\EquedLms\Helper\AccessHelper;

final class SyncController extends BaseApiController
{
    public function __construct(
        private readonly SyncService $syncService,
        ConfigurationServiceInterface $configurationService,
        ApiResponseServiceInterface $apiResponseService,
        GptTranslationServiceInterface $translationService,
        private readonly AccessHelper $accessHelper,
    ) {
        parent::__construct($configurationService, $apiResponseService, $translationService);
    }

    public function pushAction(ServerRequestInterface $request): JsonResponse
    {
        if (($check = $this->requireFeature('sync_api')) !== null) {
            return $check;
        }

        $currentUserId = $this->getCurrentUserId($request);
        $params   = $request->getQueryParams();
        $userId   = isset($params['userId']) ? (int)$params['userId'] : ($currentUserId ?? 0);

        if ($currentUserId === null) {
            return $this->jsonError('api.sync.unauthorized', JsonResponse::HTTP_UNAUTHORIZED);
        }

        if ($userId <= 0) {
            return $this->jsonError('api.sync.invalidUser', JsonResponse::HTTP_BAD_REQUEST);
        }

        if ($userId !== $currentUserId && ! $this->accessHelper->isAdmin()) {
            return $this->jsonError('api.sync.forbidden', JsonResponse::HTTP_FORBIDDEN);
        }

        try {
            $data = $this->syncService->exportProfile($userId);
            return $this->jsonSuccess($data);
        } catch (\Throwable $e) {
            return $this->jsonError('api.sync.failed', JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function pullAction(ServerRequestInterface $request): JsonResponse
    {
        if (($check = $this->requireFeature('sync_api')) !== null) {
            return $check;
        }

        $currentUserId = $this->getCurrentUserId($request);
        $data          = (array) $request->getParsedBody();

        if (empty($data['userId'])) {
            $data['userId'] = $currentUserId ?? 0;
        }

        if ($currentUserId === null) {
            return $this->jsonError('api.sync.unauthorized', JsonResponse::HTTP_UNAUTHORIZED);
        }

        if (empty($data['userId'])) {
            return $this->jsonError('api.sync.missingUser', JsonResponse::HTTP_BAD_REQUEST);
        }

        if ((int)$data['userId'] !== $currentUserId && ! $this->accessHelper->isAdmin()) {
            return $this->jsonError('api.sync.forbidden', JsonResponse::HTTP_FORBIDDEN);
        }

        try {
            $profile = $this->syncService->pullFromApp($data);
            return $this->jsonSuccess(['uuid' => $profile->getUuid()]);
        } catch (\Throwable $e) {
            return $this->jsonError('api.sync.failed', JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
