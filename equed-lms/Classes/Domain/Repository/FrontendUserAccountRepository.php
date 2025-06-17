<?php
declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;

/**
 * Default implementation of FrontendUserAccountRepositoryInterface.
 */
final class FrontendUserAccountRepository implements FrontendUserAccountRepositoryInterface
{
    public function __construct(private readonly ConnectionPool $connectionPool)
    {
    }

    public function fetchProfile(int $userId): ?array
    {
        $qb = $this->connectionPool->getQueryBuilderForTable('fe_users');
        $qb->select('uid', 'username', 'name', 'email', 'usergroup')
            ->from('fe_users')
            ->where(
                $qb->expr()->eq('uid', $qb->createNamedParameter($userId, \PDO::PARAM_INT)),
                $qb->expr()->eq('deleted', 0)
            );

        $row = $qb->executeQuery()->fetchAssociative();

        return $row === false ? null : $row;
    }

    public function updateProfile(int $userId, array $fields): void
    {
        $connection = $this->connectionPool->getConnectionForTable('fe_users');
        $connection->update('fe_users', $fields, ['uid' => $userId]);
    }
}
