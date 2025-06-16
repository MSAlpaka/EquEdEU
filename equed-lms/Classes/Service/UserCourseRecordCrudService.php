<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use Equed\EquedLms\Domain\Service\UserCourseRecordCrudServiceInterface;
use Equed\EquedLms\Domain\Service\ClockInterface;
use Equed\EquedLms\Dto\UserCourseRecordUpdateRequest;

/**
 * DB-backed implementation for managing user course records.
 */
final class UserCourseRecordCrudService implements UserCourseRecordCrudServiceInterface
{
    public function __construct(
        private readonly ConnectionPool $connectionPool,
        private readonly ClockInterface $clock
    ) {
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

    public function updateRecord(int $userId, UserCourseRecordUpdateRequest $request): void
    {
        $fields = [
            'status' => $request->getStatus(),
            'tstamp' => $this->clock->now()->getTimestamp(),
        ];

        if ($request->getProgress() !== null) {
            $fields['progress'] = $request->getProgress();
        }

        $this->connectionPool
            ->getConnectionForTable('tx_equedlms_domain_model_usercourserecord')
            ->update(
                'tx_equedlms_domain_model_usercourserecord',
                $fields,
                ['uid' => $request->getUid(), 'fe_user' => $userId]
            );
    }

    public function deleteRecord(int $userId, int $recordId): void
    {
        $this->connectionPool
            ->getConnectionForTable('tx_equedlms_domain_model_usercourserecord')
            ->update(
                'tx_equedlms_domain_model_usercourserecord',
                [
                    'deleted' => 1,
                    'tstamp' => $this->clock->now()->getTimestamp(),
                ],
                ['uid' => $recordId, 'fe_user' => $userId]
            );
    }

    private function getQueryBuilder(): QueryBuilder
    {
        return $this->connectionPool->getQueryBuilderForTable('tx_equedlms_domain_model_usercourserecord');
    }
}
