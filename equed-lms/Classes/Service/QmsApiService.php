<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use Equed\EquedLms\Domain\Service\ClockInterface;
use Equed\EquedLms\Dto\QmsSubmitRequest;
use Equed\EquedLms\Dto\QmsRespondRequest;
use Equed\EquedLms\Dto\QmsCloseRequest;

/**
 * Simple DB-driven operations for QMS API endpoints.
 */
final class QmsApiService
{
    public function __construct(
        private readonly ConnectionPool $connectionPool,
        private readonly ClockInterface $clock
    ) {
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

    public function submitCase(QmsSubmitRequest $dto): void
    {
        $now = $this->clock->now()->getTimestamp();
        $this->connectionPool->getConnectionForTable('tx_equedlms_domain_model_qms')
            ->insert(
                'tx_equedlms_domain_model_qms',
                [
                    'usercourserecord' => $dto->getRecordId(),
                    'submitted_by'     => $dto->getUserId(),
                    'type'             => $dto->getType(),
                    'message'          => $dto->getMessage(),
                    'status'           => 'open',
                    'submitted_at'     => $now,
                    'tstamp'           => $now,
                    'crdate'           => $now,
                ]
            );
    }

    public function respondToCase(QmsRespondRequest $dto): void
    {
        $now = $this->clock->now()->getTimestamp();
        $this->connectionPool->getConnectionForTable('tx_equedlms_domain_model_qms')
            ->update(
                'tx_equedlms_domain_model_qms',
                [
                    'response'       => $dto->getResponse(),
                    'responded_by'   => $dto->getUserId(),
                    'responded_role' => $dto->getRole(),
                    'responded_at'   => $now,
                    'status'         => 'responded',
                    'tstamp'         => $now,
                ],
                ['uid' => $dto->getCaseId()]
            );
    }

    public function closeCase(QmsCloseRequest $dto): void
    {
        $now = $this->clock->now()->getTimestamp();
        $this->connectionPool->getConnectionForTable('tx_equedlms_domain_model_qms')
            ->update(
                'tx_equedlms_domain_model_qms',
                [
                    'status'    => 'closed',
                    'closed_by' => $dto->getUserId(),
                    'closed_at' => $now,
                    'tstamp'    => $now,
                ],
                ['uid' => $dto->getCaseId()]
            );
    }

    private function getQueryBuilder(string $table): QueryBuilder
    {
        return $this->connectionPool->getQueryBuilderForTable($table);
    }
}

// EOF
