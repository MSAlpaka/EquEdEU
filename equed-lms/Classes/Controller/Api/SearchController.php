<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Core\Context\Context;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;

/**
 * API controller for performing global search across entities.
 * Feature flag: <search_api>
 */
final class SearchController extends ActionController
{
    public function __construct(
        private readonly ConnectionPool $connectionPool,
        private readonly ConfigurationServiceInterface $configurationService,
        private readonly GptTranslationServiceInterface $translationService,
        private readonly Context $context
    ) {
        parent::__construct();
    }

    public function searchAction(ServerRequestInterface $request): ResponseInterface
    {
        if (! $this->configurationService->isFeatureEnabled('search_api')) {
            return new JsonResponse([
                'error' => $this->translationService->translate('api.search.disabled'),
            ], 403);
        }

        $params = $request->getQueryParams();
        $term = trim((string)($params['q'] ?? ''));

        if (mb_strlen($term) < 2) {
            return new JsonResponse([
                'error' => $this->translationService->translate('api.search.tooShort'),
            ], 400);
        }

        $results = [];

        // Example search: courses by title
        $qb = $this->connectionPool->getQueryBuilderForTable('tx_equedlms_domain_model_course');
        $courses = $qb
            ->select('uid', 'title', 'description')
            ->from('tx_equedlms_domain_model_course')
            ->where(
                $qb->expr()->like('title', $qb->createNamedParameter('%' . $term . '%')),
                $qb->expr()->eq('deleted', 0)
            )
            ->setMaxResults(10)
            ->executeQuery()
            ->fetchAllAssociative();

        $results['courses'] = $courses;

        return new JsonResponse([
            'status'  => 'success',
            'results' => $results,
        ]);
    }
}
