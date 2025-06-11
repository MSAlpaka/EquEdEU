<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Context\Context;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Repository\UserRepositoryInterface;
use Equed\EquedLms\Domain\Service\DashboardServiceInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * API controller for retrieving dashboard data for the authenticated user.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <dashboard_api> feature toggle.
 */
final class DashboardApiController extends ActionController
{
    public function __construct(
        private readonly DashboardServiceInterface         $dashboardService,
        private readonly UserRepositoryInterface           $userRepository,
        private readonly ConfigurationServiceInterface     $configurationService,
        private readonly GptTranslationServiceInterface    $translationService,
        private readonly Context                           $context
    ) {
        parent::__construct();
    }

    /**
     * Returns dashboard data for the current user.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function showAction(ServerRequestInterface $request): JsonResponse
    {
        if (! $this->configurationService->isFeatureEnabled('dashboard_api')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.dashboard.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $userContext = $this->context->getAspect('frontend.user')->get('user');
        $userId = is_array($userContext) && isset($userContext['uid'])
            ? (int)$userContext['uid']
            : null;

        if ($userId === null) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.dashboard.unauthorized')],
                JsonResponse::HTTP_UNAUTHORIZED
            );
        }

        $user = $this->userRepository->findByUid($userId);
        if ($user === null) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.dashboard.userNotFound')],
                JsonResponse::HTTP_NOT_FOUND
            );
        }

        $data = $this->dashboardService->getDashboardDataForUser($user);

        return new JsonResponse([
            'status' => 'success',
            'data'   => $data,
        ]);
    }
}
// End of file
