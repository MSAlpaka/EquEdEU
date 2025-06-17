<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;

/**
 * Doctrine DBAL implementation of QmsCaseRecordRepositoryInterface.
 */
final class QmsCaseRecordRepository implements QmsCaseRecordRepositoryInterface
{
    private Connection $connection;

    public function __construct(ConnectionPool $connectionPool)
    {
        $this->connection = $connectionPool->getConnectionForTable('tx_equedlms_domain_model_qms');
    }

    public function findByUserId(int $userId): array
    {
        $qb = $this->connection->createQueryBuilder();
        $qb->select('uid', 'usercourserecord', 'type', 'message', 'status', 'submitted_at', 'responded_at', 'closed_at')
            ->from('tx_equedlms_domain_model_qms')
            ->where(
                $qb->expr()->eq('submitted_by', $qb->createNamedParameter($userId, \PDO::PARAM_INT)),
                $qb->expr()->eq('deleted', 0)
            )
            ->orderBy('submitted_at', 'DESC');

        return $qb->executeQuery()->fetchAllAssociative();
    }

    public function findAll(): array
    {
        $qb = $this->connection->createQueryBuilder();
        $qb->select('*')
            ->from('tx_equedlms_domain_model_qms')
            ->where($qb->expr()->eq('deleted', 0))
            ->orderBy('submitted_at', 'DESC');

        return $qb->executeQuery()->fetchAllAssociative();
    }

    public function addCase(int $userId, int $recordId, string $type, string $message, int $timestamp): void
    {
        $this->connection->insert('tx_equedlms_domain_model_qms', [
            'usercourserecord' => $recordId,
            'submitted_by'     => $userId,
            'type'             => $type,
            'message'          => $message,
            'status'           => 'open',
            'submitted_at'     => $timestamp,
            'tstamp'           => $timestamp,
            'crdate'           => $timestamp,
        ]);
    }

    public function respondToCase(int $caseId, int $userId, string $role, string $response, int $timestamp): void
    {
        $this->connection->update('tx_equedlms_domain_model_qms', [
            'response'       => $response,
            'responded_by'   => $userId,
            'responded_role' => $role,
            'responded_at'   => $timestamp,
            'status'         => 'responded',
            'tstamp'         => $timestamp,
        ], ['uid' => $caseId]);
    }

    public function closeCase(int $caseId, int $userId, int $timestamp): void
    {
        $this->connection->update('tx_equedlms_domain_model_qms', [
            'status'    => 'closed',
            'closed_by' => $userId,
            'closed_at' => $timestamp,
            'tstamp'    => $timestamp,
        ], ['uid' => $caseId]);
    }
}
