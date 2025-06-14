<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Service\SyncService;
use Equed\EquedLms\Domain\Repository\UserProfileRepositoryInterface;

final class SyncController extends ActionController
{
    public function __construct(
        private readonly SyncService                    $syncService,
        private readonly UserProfileRepositoryInterface $profileRepository,
        private readonly GptTranslationServiceInterface $translationService,
        private readonly Context                        $context,
    ) {
        parent::__construct();
    }

    public function pushAction(ServerRequestInterface $request): ResponseInterface
    {
        $userId = (int)($request->getQueryParams()['userId'] ?? 0);
        if ($userId <= 0) {
            $user = $this->context->getAspect('frontend.user')->get('user');
            $userId = is_array($user) && isset($user['uid']) ? (int)$user['uid'] : 0;
        }
        if ($userId <= 0) {
            return $this->createJsonResponse([
                'error' => $this->translationService->translate('api.sync.invalidUser')
            ], 400);
        }

        try {
            $profile = $this->profileRepository->findByUserId($userId);
            if ($profile === null) {
                return $this->createJsonResponse([
                    'error' => $this->translationService->translate('api.sync.invalidUser')
                ], 400);
            }
            $data = $this->syncService->pushToApp($profile);
            return $this->createJsonResponse($data);
        } catch (\Throwable $e) {
            return $this->createJsonResponse(['error' => $e->getMessage()], 500);
        }
    }

    public function pullAction(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();
        if (empty($data['userId'])) {
            $user = $this->context->getAspect('frontend.user')->get('user');
            $data['userId'] = is_array($user) && isset($user['uid']) ? (int)$user['uid'] : 0;
        }

        if (empty($data['userId'])) {
            return $this->createJsonResponse([
                'error' => $this->translationService->translate('api.sync.missingUser')
            ], 400);
        }

        try {
            $profile = $this->syncService->pullFromApp($data);
            return $this->createJsonResponse(['status' => 'ok', 'uuid' => $profile->getUuid()]);
        } catch (\Throwable $e) {
            return $this->createJsonResponse(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @param array<int|string, mixed> $data
     */
    protected function createJsonResponse(array $data, int $status = 200): ResponseInterface
    {
        return new JsonResponse($data, $status);
    }
}
