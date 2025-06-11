<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Context\Context;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\ProgressServiceInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * API controller for retrieving user progress data.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <progress_api> feature toggle.
 */
final class ProgressApiController extends ActionController
{
    public function __construct(
        private readonly ProgressServiceInterface          $progressService,
        private readonly ConfigurationServiceInterface     $configurationService,
        private readonly GptTranslationServiceInterface    $translationService,
        private readonly Context                           $context
    ) {
        parent::__construct();
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
        if (! $this->configurationService->isFeatureEnabled('progress_api')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.progress.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $currentUser = $this->context->getAspect('frontend.user')->get('user');
        $currentUserId = is_array($currentUser) && isset($currentUser['uid']) ? (int)$currentUser['uid'] : null;
        if ($currentUserId === null) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.progress.unauthorized')],
                JsonResponse::HTTP_UNAUTHORIZED
            );
        }

        $params = $request->getQueryParams();
        $userId = isset($params['user']) ? (int)$params['user'] : $currentUserId;

        // only admins may view others' progress
        if ($userId !== $currentUserId && ! $this->progressService->isAdmin($currentUserId)) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.progress.forbidden')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $data = $this->progressService->getProgressDataForUser($userId);
        return new JsonResponse($data, JsonResponse::HTTP_OK);
    }
}
// End of file
