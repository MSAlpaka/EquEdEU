<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;

/**
 * API controller for Service Center operations:
 * - View QMS cases
 * - Respond or close
 * - Trigger reports
 */
final class ServiceCenterController extends ActionController
{
    public function __construct(
        private readonly ConnectionPool $connectionPool,
        private readonly ConfigurationServiceInterface $configurationService,
        private readonly GptTranslationServiceInterface $translationService,
    ) {
        parent::__construct();
    }

    public function listQmsCasesAction(ServerRequestInterface $request): ResponseInterface
    {
        if (! $this->configurationService->isFeatureEnabled('service_center_api')) {
            return new JsonResponse([
                'error' => $this->translationService->translate('api.serviceCenter.disabled')
            ], 403);
        }

        $user = $request->getAttribute('user');
        $userGroups = is_array($user) ? $user['usergroup'] ?? [] : [];

        if (!is_array($userGroups) || !in_array('service_center', $userGroups)) {
            return new JsonResponse([
                'error' => $this->translationService->translate('api.serviceCenter.unauthorized')
            ], 401);
        }

        $qb = $this->connectionPool->getQueryBuilderForTable('tx_equedlms_domain_model_qms');
        $cases = $qb
            ->select('*')
            ->from('tx_equedlms_domain_model_qms')
            ->where($qb->expr()->eq('deleted', 0))
            ->orderBy('submitted_at', 'DESC')
            ->executeQuery()
            ->fetchAllAssociative();

        return new JsonResponse([
            'status' => 'success',
            'cases' => $cases,
        ]);
    }
}
