<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;

/**
 * Simple DB-driven operations for QMS API endpoints.
 */
final class QmsApiService
{
    public function __construct(private readonly ConnectionPool $connectionPool)
    {
    }

    /**
     * Fetch QMS cases submitted by the given user.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getCasesForUser(int $userId): array
    {
        $qb = $this->getQueryBuilder('tx_equedlms_domain_model_qms');
        $qb->select('uid', 'usercourserecord', 'type', 'message', 'status', 'submitted_at', 'responded_at', 'closed_at')
            ->from('tx_equedlms_domain_model_qms')
            ->where(
                $qb->expr()->eq('submitted_by', $qb->createNamedParameter($userId, \PDO::PARAM_INT)),
                $qb->expr()->eq('deleted', 0)
            )
            ->orderBy('submitted_at', 'DESC');

        return $qb->executeQuery()->fetchAllAssociative();
    }

    public function submitCase(int $userId, int $recordId, string $message, string $type = 'general'): void
    {
        $now = time();
        $this->connectionPool->getConnectionForTable('tx_equedlms_domain_model_qms')
            ->insert(
                'tx_equedlms_domain_model_qms',
                [
                    'usercourserecord' => $recordId,
                    'submitted_by'     => $userId,
                    'type'             => $type,
                    'message'          => $message,
                    'status'           => 'open',
                    'submitted_at'     => $now,
                    'tstamp'           => $now,
                    'crdate'           => $now,
                ]
            );
    }

    public function respondToCase(int $userId, int $caseId, string $response, string $role = 'certifier'): void
    {
        $now = time();
        $this->connectionPool->getConnectionForTable('tx_equedlms_domain_model_qms')
            ->update(
                'tx_equedlms_domain_model_qms',
                [
                    'response'       => $response,
                    'responded_by'   => $userId,
                    'responded_role' => $role,
                    'responded_at'   => $now,
                    'status'         => 'responded',
                    'tstamp'         => $now,
                ],
                ['uid' => $caseId]
            );
    }

    public function closeCase(int $userId, int $caseId): void
    {
        $now = time();
        $this->connectionPool->getConnectionForTable('tx_equedlms_domain_model_qms')
            ->update(
                'tx_equedlms_domain_model_qms',
                [
                    'status'    => 'closed',
                    'closed_by' => $userId,
                    'closed_at' => $now,
                    'tstamp'    => $now,
                ],
                ['uid' => $caseId]
            );
    }

    private function getQueryBuilder(string $table): QueryBuilder
    {
        return $this->connectionPool->getQueryBuilderForTable($table);
    }
}

// EOF
