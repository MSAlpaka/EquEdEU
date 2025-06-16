<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use Equed\EquedLms\Domain\Service\UserCourseRecordCrudServiceInterface;

/**
 * DB-backed implementation for managing user course records.
 */
final class UserCourseRecordCrudService implements UserCourseRecordCrudServiceInterface
{
    public function __construct(private readonly ConnectionPool $connectionPool)
    {
    }

    public function listForUser(int $userId): array
    {
        $qb = $this->getQueryBuilder();
        $qb->select('uid', 'course_instance', 'status', 'progress', 'validated', 'feedback_submitted')
            ->from('tx_equedlms_domain_model_usercourserecord')
            ->where(
                $qb->expr()->eq('fe_user', $qb->createNamedParameter($userId, \PDO::PARAM_INT)),
                $qb->expr()->eq('deleted', 0)
            )
            ->orderBy('tstamp', 'DESC');

        return $qb->executeQuery()->fetchAllAssociative();
    }

    public function getForUser(int $userId, int $recordId): ?array
    {
        $qb = $this->getQueryBuilder();
        $qb->select('*')
            ->from('tx_equedlms_domain_model_usercourserecord')
            ->where(
                $qb->expr()->eq('uid', $qb->createNamedParameter($recordId, \PDO::PARAM_INT)),
                $qb->expr()->eq('fe_user', $qb->createNamedParameter($userId, \PDO::PARAM_INT)),
                $qb->expr()->eq('deleted', 0)
            );

        $record = $qb->executeQuery()->fetchAssociative();

        return $record === false ? null : $record;
    }

    public function updateRecord(int $userId, int $recordId, array $fields): void
    {
        $fields['tstamp'] = time();
        $this->connectionPool
            ->getConnectionForTable('tx_equedlms_domain_model_usercourserecord')
            ->update(
                'tx_equedlms_domain_model_usercourserecord',
                $fields,
                ['uid' => $recordId, 'fe_user' => $userId]
            );
    }

    public function deleteRecord(int $userId, int $recordId): void
    {
        $this->updateRecord($userId, $recordId, ['deleted' => 1]);
    }

    private function getQueryBuilder(): QueryBuilder
    {
        return $this->connectionPool->getQueryBuilderForTable('tx_equedlms_domain_model_usercourserecord');
    }
}
