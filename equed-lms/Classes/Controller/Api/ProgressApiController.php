<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Domain\Service\ApiResponseServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Service\ProgressServiceInterface;
use Equed\EquedLms\Controller\Api\BaseApiController;

/**
 * API controller for retrieving user progress data.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <progress_api> feature toggle.
 */
final class ProgressApiController extends BaseApiController
{
    public function __construct(
        private readonly ProgressServiceInterface       $progressService,
        ConfigurationServiceInterface                  $configurationService,
        ApiResponseServiceInterface                    $apiResponseService,
        GptTranslationServiceInterface                 $translationService,
    ) {
    }

    /**
     * Shows progress data for the authenticated user or a specified user (admins only).
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function showAction(ServerRequestInterface $request): JsonResponse
    {
        if (($check = $this->requireFeature('progress_api')) !== null) {
            return $check;
        }

        $currentUserId = $this->getCurrentUserId($request);
        if ($currentUserId === null) {
            return $this->jsonError('api.progress.unauthorized', JsonResponse::HTTP_UNAUTHORIZED);
        }

        $params = $request->getQueryParams();
        $userId = isset($params['user']) ? (int)$params['user'] : $currentUserId;

        // only admins may view others' progress
        if ($userId !== $currentUserId && ! $this->progressService->isAdmin($currentUserId)) {
            return $this->jsonError('api.progress.forbidden', JsonResponse::HTTP_FORBIDDEN);
        }

        $data = $this->progressService->getProgressDataForUser($userId);

        return $this->jsonSuccess($data);
    }
}
