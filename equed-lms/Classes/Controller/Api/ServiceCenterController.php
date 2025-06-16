<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Domain\Service\ApiResponseServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Service\ServiceCenterCaseService;
use Equed\EquedLms\Controller\Api\BaseApiController;

/**
 * API controller for Service Center operations:
 * - View QMS cases
 * - Respond or close
 * - Trigger reports
 */
final class ServiceCenterController extends BaseApiController
{
    public function __construct(
        private readonly ServiceCenterCaseService $caseService,
        ConfigurationServiceInterface $configurationService,
        ApiResponseServiceInterface $apiResponseService,
        GptTranslationServiceInterface $translationService,
    ) {
        parent::__construct($configurationService, $apiResponseService, $translationService);
    }

    public function listQmsCasesAction(ServerRequestInterface $request): JsonResponse
    {
        if (($check = $this->requireFeature('service_center_api')) !== null) {
            return $check;
        }

        $user = $request->getAttribute('user');
        $userGroups = is_array($user) ? ($user['usergroup'] ?? []) : [];

        if (!is_array($userGroups) || !in_array('service_center', $userGroups)) {
            return $this->jsonError('api.serviceCenter.unauthorized', JsonResponse::HTTP_UNAUTHORIZED);
        }

        $cases = $this->caseService->getQmsCases();

        return $this->jsonSuccess([
            'cases' => $cases,
        ]);
    }
}
