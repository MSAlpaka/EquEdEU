<?php
declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;
use Equed\EquedLms\Dto\CourseSearchResult;
use Equed\EquedLms\Dto\GlossarySearchResult;

final class SearchRepository implements SearchRepositoryInterface
{
    public function __construct(
        private readonly ConnectionPool $connectionPool
    ) {
    }

    /**
     * Search courses by title or description.
     *
     * @param string $term Search term
     * @return CourseSearchResult[]
     */
    public function searchCourses(string $term): array
    {
        $qb   = $this->connectionPool->getQueryBuilderForTable('tx_equedlms_domain_model_course');
        $expr = $qb->expr();
        $qb->select('uid', 'title', 'description')
            ->from('tx_equedlms_domain_model_course')
            ->where(
                $expr->orX(
                    $expr->like('title', $qb->createNamedParameter('%' . $term . '%')),
                    $expr->like('description', $qb->createNamedParameter('%' . $term . '%')),
                )
            )
            ->setMaxResults(10);

        $rows = $qb->executeQuery()->fetchAllAssociative();

        $results = [];
        foreach ($rows as $row) {
            $results[] = new CourseSearchResult(
                (int) $row['uid'],
                (string) $row['title'],
                (string) $row['description'],
            );
        }

        return $results;
    }

    /**
     * Search glossary terms and definitions.
     *
     * @param string $term Search term
     * @return GlossarySearchResult[]
     */
    public function searchGlossary(string $term): array
    {
        $qb   = $this->connectionPool->getQueryBuilderForTable('tx_equedlms_domain_model_glossaryentry');
        $expr = $qb->expr();
        $qb->select('uid', 'term', 'definition')
            ->from('tx_equedlms_domain_model_glossaryentry')
            ->where(
                $expr->orX(
                    $expr->like('term', $qb->createNamedParameter('%' . $term . '%')),
                    $expr->like('definition', $qb->createNamedParameter('%' . $term . '%')),
                )
            )
            ->setMaxResults(10);

        $rows = $qb->executeQuery()->fetchAllAssociative();

        $results = [];
        foreach ($rows as $row) {
            $results[] = new GlossarySearchResult(
                (int) $row['uid'],
                (string) $row['term'],
                (string) $row['definition'],
            );
        }

        return $results;
    }
}
