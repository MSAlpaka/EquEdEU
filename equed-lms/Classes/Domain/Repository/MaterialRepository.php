<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;

/**
 * Doctrine DBAL implementation of {@see MaterialRepositoryInterface}.
 */
final class MaterialRepository implements MaterialRepositoryInterface
{
    private Connection $connection;

    public function __construct(ConnectionPool $connectionPool)
    {
        $this->connection = $connectionPool->getConnectionForTable('tx_equedlms_domain_model_material');
    }

    /**
     * {@inheritDoc}
     */
    public function findByTypeAndCategory(string $type, string $category): array
    {
        $qb = $this->connection->createQueryBuilder();
        $qb
            ->select('*')
            ->from('tx_equedlms_domain_model_material')
            ->where(
                $qb->expr()->eq('type', $qb->createNamedParameter($type)),
                $qb->expr()->eq('category', $qb->createNamedParameter($category)),
                $qb->expr()->eq('deleted', 0)
            )
            ->orderBy('title', 'ASC');

        return $qb->executeQuery()->fetchAllAssociative();
    }
}
