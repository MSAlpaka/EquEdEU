<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Core\Database\ConnectionPool;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;

/**
 * API controller for recognition awards.
 *
 * Retrieves recognitions for the authenticated user.
 * Feature toggle: <recognition_api>
 */
final class RecognitionAwardController extends ActionController
{
    public function __construct(
        private readonly ConnectionPool $connectionPool,
        private readonly ConfigurationServiceInterface $configurationService,
        private readonly GptTranslationServiceInterface $translationService,
    ) {
        parent::__construct();
    }

    public function listMyAwardsAction(ServerRequestInterface $request): ResponseInterface
    {
        if (! $this->configurationService->isFeatureEnabled('recognition_api')) {
            return new JsonResponse([
                'error' => $this->translationService->translate('api.recognition.disabled'),
            ], 403);
        }

        $user = $request->getAttribute('user');
        $userId = is_array($user) && isset($user['uid']) ? (int)$user['uid'] : null;

        if ($userId === null) {
            return new JsonResponse([
                'error' => $this->translationService->translate('api.recognition.unauthorized'),
            ], 401);
        }

        $qb = $this->connectionPool->getQueryBuilderForTable('tx_equedlms_domain_model_recognitionaward');
        $results = $qb
            ->select('uid', 'title', 'issued_at', 'level', 'description')
            ->from('tx_equedlms_domain_model_recognitionaward')
            ->where(
                $qb->expr()->eq('user_id', $qb->createNamedParameter($userId, \PDO::PARAM_INT)),
                $qb->expr()->eq('deleted', 0)
            )
            ->orderBy('issued_at', 'DESC')
            ->executeQuery()
            ->fetchAllAssociative();

        return new JsonResponse([
            'status' => 'success',
            'awards' => $results,
        ]);
    }
}
