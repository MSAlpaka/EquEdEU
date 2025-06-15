<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Equed\EquedLms\Service\ServiceCenterDashboardService;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;

/**
 * API controller for Service Center dashboard.
 *
 * Feature flag: <service_center_dashboard_api>
 */
final class ServiceCenterDashboardApiController extends ActionController
{
    public function __construct(
        private readonly ServiceCenterDashboardService $dashboardService,
        private readonly ConfigurationServiceInterface $configurationService,
        private readonly GptTranslationServiceInterface $translationService,
    ) {
        parent::__construct();
    }

    public function showAction(ServerRequestInterface $request): ResponseInterface
    {
        if (! $this->configurationService->isFeatureEnabled('service_center_dashboard_api')) {
            return new JsonResponse([
                'error' => $this->translationService->translate('api.serviceCenter.dashboardDisabled')
            ], 403);
        }

        $user = $request->getAttribute('user');
        $userGroups = is_array($user) ? ($user['usergroup'] ?? []) : [];

        if (!is_array($userGroups) || !in_array('service_center', $userGroups)) {
            return new JsonResponse([
                'error' => $this->translationService->translate('api.serviceCenter.unauthorized')
            ], 401);
        }

        $data = $this->dashboardService->getDashboardData();

        return new JsonResponse([
            'status' => 'success',
            'data'   => $data,
        ]);
    }
}
