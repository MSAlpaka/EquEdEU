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

final class SyncController extends BaseApiController
{
    public function __construct(
        private readonly SyncService $syncService,
        ConfigurationServiceInterface $configurationService,
        ApiResponseServiceInterface $apiResponseService,
        GptTranslationServiceInterface $translationService,
    ) {
        parent::__construct($configurationService, $apiResponseService, $translationService);
    }

    public function pushAction(ServerRequestInterface $request): JsonResponse
    {
        $userId = (int)($request->getQueryParams()['userId'] ?? 0);
        if ($userId <= 0) {
            $user = $request->getAttribute('user');
            $userId = is_array($user) && isset($user['uid']) ? (int)$user['uid'] : 0;
        }
        if ($userId <= 0) {
            return $this->jsonError('api.sync.invalidUser', JsonResponse::HTTP_BAD_REQUEST);
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
        $data = $request->getParsedBody();
        if (empty($data['userId'])) {
            $user = $request->getAttribute('user');
            $data['userId'] = is_array($user) && isset($user['uid']) ? (int)$user['uid'] : 0;
        }

        if (empty($data['userId'])) {
            return $this->jsonError('api.sync.missingUser', JsonResponse::HTTP_BAD_REQUEST);
        }

        try {
            $profile = $this->syncService->pullFromApp($data);
            return $this->jsonSuccess(['uuid' => $profile->getUuid()]);
        } catch (\Throwable $e) {
            return $this->jsonError('api.sync.failed', JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
