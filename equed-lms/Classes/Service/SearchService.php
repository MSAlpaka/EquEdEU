<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use Equed\EquedLms\Dto\SearchResults;

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
     */
    public function search(string $term): SearchResults
    {
        if (mb_strlen($term) < 2) {
            return new SearchResults([], [], 'Search term too short.');
        }

        $courses = $this->searchTable(
            'tx_equedlms_domain_model_course',
            ['title', 'description'],
            $term
        );

        $glossary = $this->searchTable(
            'tx_equedlms_domain_model_glossaryentry',
            ['term', 'definition'],
            $term
        );

        return new SearchResults($courses, $glossary);
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
