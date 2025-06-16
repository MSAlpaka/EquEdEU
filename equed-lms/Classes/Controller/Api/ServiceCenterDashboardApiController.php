<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Equed\EquedLms\Service\ServiceCenterDashboardService;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Domain\Service\ApiResponseServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Controller\Api\BaseApiController;

/**
 * API controller for Service Center dashboard.
 *
 * Feature flag: <service_center_dashboard_api>
 */
final class ServiceCenterDashboardApiController extends BaseApiController
{
    public function __construct(
        private readonly ServiceCenterDashboardService $dashboardService,
        ConfigurationServiceInterface $configurationService,
        ApiResponseServiceInterface $apiResponseService,
        GptTranslationServiceInterface $translationService,
    ) {
    }

    public function showAction(ServerRequestInterface $request): JsonResponse
    {
        if (($check = $this->requireFeature('service_center_dashboard_api')) !== null) {
            return $check;
        }

        $user = $request->getAttribute('user');
        $userGroups = is_array($user) ? ($user['usergroup'] ?? []) : [];

        if (! is_array($userGroups) || ! in_array('service_center', $userGroups, true)) {
            return $this->jsonError('api.serviceCenter.unauthorized', JsonResponse::HTTP_UNAUTHORIZED);
        }

        $centerId = $this->getCurrentUserId($request);
        if ($centerId === null) {
            return $this->jsonError('api.serviceCenter.unauthorized', JsonResponse::HTTP_UNAUTHORIZED);
        }

        $data = $this->dashboardService->getDashboardDataForServiceCenter($centerId);

        return $this->jsonSuccess([
            'data' => $data,
        ]);
    }
}
