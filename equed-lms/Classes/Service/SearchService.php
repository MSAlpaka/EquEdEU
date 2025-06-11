<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Provides search capabilities across multiple entities.
 */
final class SearchService
{
    public function __construct(
        private readonly ConnectionPool $connectionPool
    ) {
    }

    /**
     * Performs a global search across relevant tables.
     *
     * @param string $term
     * @return array<string, mixed>
     */
    public function search(string $term): array
    {
        $results = [];

        if (mb_strlen($term) < 2) {
            return ['error' => 'Search term too short.'];
        }

        $results['courses'] = $this->searchTable(
            'tx_equedlms_domain_model_course',
            ['title', 'description'],
            $term
        );

        $results['glossary'] = $this->searchTable(
            'tx_equedlms_domain_model_glossaryentry',
            ['term', 'definition'],
            $term
        );

        return $results;
    }

    /**
     * Generic search within a table.
     *
     * @param string $table
     * @param array<string> $columns
     * @param string $term
     * @return array<int, array<string, mixed>>
     */
    private function searchTable(string $table, array $columns, string $term): array
    {
        $qb = $this->getQueryBuilder($table);
        $expr = $qb->expr();

        $conditions = [];
        foreach ($columns as $column) {
            $conditions[] = $expr->like($column, $qb->createNamedParameter('%' . $term . '%'));
        }

        $qb->select('*')
            ->from($table)
            ->where($expr->orX(...$conditions))
            ->setMaxResults(10);

        return $qb->executeQuery()->fetchAllAssociative();
    }

    private function getQueryBuilder(string $table): QueryBuilder
    {
        return $this->connectionPool->getQueryBuilderForTable($table);
    }
}
