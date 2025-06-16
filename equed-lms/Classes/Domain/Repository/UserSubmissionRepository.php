<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\Lesson;
use Equed\EquedLms\Domain\Model\PracticeTest;
use Equed\EquedLms\Domain\Model\UserSubmission;
use Equed\EquedLms\Enum\SubmissionStatus;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository for UserSubmission entities.
 *
 * @extends Repository<UserSubmission>
 */
final class UserSubmissionRepository extends Repository implements UserSubmissionRepositoryInterface
{
    private Connection $connection;

    public function __construct(ConnectionPool $connectionPool)
    {
        parent::__construct();
        $this->connection = $connectionPool->getConnectionForTable(
            'tx_equedlms_domain_model_usersubmission'
        );
    }
    /**
     * Default ordering: newest submissions first.
     *
     * @var array<string,int>
     */
    protected array $defaultOrderings = [
        'createdAt' => QueryInterface::ORDER_DESCENDING,
    ];

    /**
     * Find all submissions for a given UserCourseRecord.
     *
     * @param int $userCourseRecordUid
     * @return UserSubmission[]
     */
    public function findByUserCourseRecord(int $userCourseRecordUid): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('userCourseRecord', $userCourseRecordUid)
        );

        return $query->execute()->toArray();
    }

    /**
     * {@inheritDoc}
     */
    public function findScoresByUserCourseRecord(int $userCourseRecordUid): array
    {
        $queryBuilder = $this->createQuery()->getQueryBuilder();
        $queryBuilder
            ->select('us.points_awarded AS points', 'us.max_points AS maxPoints')
            ->from('tx_equedlms_domain_model_usersubmission', 'us')
            ->join(
                'us',
                'tx_equedlms_domain_model_usercourserecord',
                'ucr',
                'ucr.uid = :ucrUid AND us.course_instance = ucr.course_instance AND us.frontend_user = ucr.fe_user'
            )
            ->setParameter('ucrUid', $userCourseRecordUid, \PDO::PARAM_INT);

        $rows = $queryBuilder->executeQuery()->fetchAllAssociative();

        return array_map(
            static function (array $row): array {
                return [
                    'points'    => isset($row['points']) ? (float) $row['points'] : null,
                    'maxPoints' => isset($row['maxPoints']) ? (float) $row['maxPoints'] : null,
                ];
            },
            $rows
        );
    }

    /**
     * Find all submissions for a specific lesson.
     *
     * @param Lesson $lesson
     * @return UserSubmission[]
     */
    public function findByLesson(Lesson $lesson): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('lesson', $lesson)
        );

        return $query->execute()->toArray();
    }

    /**
     * Find all submissions for a specific practice test.
     *
     * @param PracticeTest $practiceTest
     * @return UserSubmission[]
     */
    public function findByPracticeTest(PracticeTest $practiceTest): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('practiceTest', $practiceTest)
        );

        return $query->execute()->toArray();
    }

    /**
     * Find a submission by its UUID.
     *
     * @param string $uuid
     * @return UserSubmission|null
     */
    public function findByUuid(string $uuid): ?UserSubmission
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('uuid', $uuid)
        );
        $query->setLimit(1);

        return $query->execute()->getFirst();
    }

    /**
     * Count submissions for a specific lesson.
     *
     * @param Lesson $lesson
     * @return int
     */
    public function countByLesson(Lesson $lesson): int
    {
        $qb = $this->createQuery()->getQueryBuilder();
        $qb
            ->select($qb->expr()->count('*'))
            ->from('tx_equedlms_domain_model_usersubmission')
            ->where(
                $qb->expr()->eq('lesson', $qb->createNamedParameter($lesson->getUid(), \PDO::PARAM_INT))
            );

        $result = $qb->executeQuery()->fetchOne();

        return $result === false ? 0 : (int)$result;
    }

    /**
     * Count submissions for a specific practice test.
     *
     * @param PracticeTest $practiceTest
     * @return int
     */
    public function countByPracticeTest(PracticeTest $practiceTest): int
    {
        $qb = $this->createQuery()->getQueryBuilder();
        $qb
            ->select($qb->expr()->count('*'))
            ->from('tx_equedlms_domain_model_usersubmission')
            ->where(
                $qb->expr()->eq('practice_test', $qb->createNamedParameter($practiceTest->getUid(), \PDO::PARAM_INT))
            );

        $result = $qb->executeQuery()->fetchOne();

        return $result === false ? 0 : (int)$result;
    }

    /**
     * Count submissions with status "submitted" for the given lesson.
     *
     * @param Lesson $lesson
     * @return int
     */
    public function countSubmittedByLesson(Lesson $lesson): int
    {
        $qb = $this->createQuery()->getQueryBuilder();
        $qb
            ->select($qb->expr()->count('*'))
            ->from('tx_equedlms_domain_model_usersubmission')
            ->where(
                $qb->expr()->eq('lesson', $qb->createNamedParameter($lesson->getUid(), \PDO::PARAM_INT)),
                $qb->expr()->eq('status', $qb->createNamedParameter('submitted'))
            );

        $result = $qb->executeQuery()->fetchOne();

        return $result === false ? 0 : (int)$result;
    }

    /**
     * Count all submissions with status "submitted".
     */
    public function countSubmitted(): int
    {
        $qb = $this->createQuery()->getQueryBuilder();
        $qb
            ->select($qb->expr()->count('*'))
            ->from('tx_equedlms_domain_model_usersubmission')
            ->where(
                $qb->expr()->eq('status', $qb->createNamedParameter('submitted'))
            );

        $result = $qb->executeQuery()->fetchOne();

        return $result === false ? 0 : (int) $result;
    }

    /**
     * Count pending submissions for a specific course instance.
     *
     * @param int $courseInstanceId
     * @return int
     */
    public function countPendingByCourseInstance(int $courseInstanceId): int
    {
        $qb = $this->createQuery()->getQueryBuilder();
        $qb
            ->select($qb->expr()->count('*'))
            ->from('tx_equedlms_domain_model_usersubmission')
            ->where(
                $qb->expr()->eq('course_instance', $qb->createNamedParameter($courseInstanceId, \PDO::PARAM_INT)),
                $qb->expr()->eq('status', $qb->createNamedParameter(SubmissionStatus::Pending->value))
            );

        $result = $qb->executeQuery()->fetchOne();

        return $result === false ? 0 : (int)$result;
    }

    /**
     * Count submissions by status.
     *
     * @param SubmissionStatus|string $status
     * @return int
     */
    public function countByStatus(SubmissionStatus|string $status): int
    {
        if (is_string($status)) {
            $status = SubmissionStatus::from($status);
        }

        $qb = $this->createQuery()->getQueryBuilder();
        $qb
            ->select($qb->expr()->count('*'))
            ->from('tx_equedlms_domain_model_usersubmission')
            ->where(
                $qb->expr()->eq('status', $qb->createNamedParameter($status->value))
            );

        $result = $qb->executeQuery()->fetchOne();

        return $result === false ? 0 : (int) $result;
    }

    /**
     * Find submissions by status.
     *
     * @param SubmissionStatus|string $status
     * @return UserSubmission[]
     */
    public function findByStatus(SubmissionStatus|string $status): array
    {
        if (is_string($status)) {
            $status = SubmissionStatus::from($status);
        }

        $query = $this->createQuery();
        $query->matching(
            $query->equals('status', $status->value)
        );

        return $query->execute()->toArray();
    }

    /**
     * Find all pending submissions (status = 'pending').
     *
     * @return UserSubmission[]
     */
    public function findPending(): array
    {
        return $this->findByStatus(SubmissionStatus::Pending);
    }

    /**
     * Find latest submission for a UserCourseRecord.
     *
     * @param int $userCourseRecordUid
     * @return UserSubmission|null
     */
    public function findLatestByUserCourseRecord(int $userCourseRecordUid): ?UserSubmission
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('userCourseRecord', $userCourseRecordUid)
        );
        $query->setOrderings(['createdAt' => QueryInterface::ORDER_DESCENDING]);
        $query->setLimit(1);

        return $query->execute()->getFirst();
    }

    /**
     * Find submissions pending instructor feedback for a given instructor.
     *
     * @param int $feUserId Instructor FE user UID
     * @return UserSubmission[]
     */
    public function findPendingSubmissionsForInstructor(int $feUserId): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd([
                $query->equals('userCourseRecord.courseInstance.instructor', $feUserId),
                $query->equals('status', SubmissionStatus::Pending->value),
            ])
        );

        return $query->execute()->toArray();
    }

    /**
     * Count submissions for a specific course instance.
     *
     * @param int $courseInstanceId
     * @return int
     */
    public function countByCourseInstance(int $courseInstanceId): int
    {
        $qb = $this->createQuery()->getQueryBuilder();
        $qb
            ->select($qb->expr()->count('*'))
            ->from('tx_equedlms_domain_model_usersubmission')
            ->where(
                $qb->expr()->eq('course_instance', $qb->createNamedParameter($courseInstanceId, \PDO::PARAM_INT))
            );

        $result = $qb->executeQuery()->fetchOne();

        return $result === false ? 0 : (int)$result;
    }

    /**
     * Find submissions by frontend user.
     *
     * @return UserSubmission[]
     */
    public function findByFeUser(int $feUserId): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('userCourseRecord.user', $feUserId)
        );

        return $query->execute()->toArray();
    }

    /**
     * Find submissions by course instance UID.
     *
     * @return UserSubmission[]
     */
    public function findByCourseInstance(int $courseInstanceId): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('userCourseRecord.courseInstance', $courseInstanceId)
        );

        return $query->execute()->toArray();
    }

    /**
     * Find a submission by UID.
     *
     * @param int $uid
     * @return UserSubmission|null
     */
    public function findByUid(int $uid): ?UserSubmission
    {
        /** @var UserSubmission|null $result */
        $result = parent::findByUid($uid);

        return $result;
    }

    public function createSubmission(
        int $userId,
        int $recordId,
        string $note,
        string $file,
        string $type,
        int $timestamp
    ): void {
        $this->connection->insert(
            'tx_equedlms_domain_model_usersubmission',
            [
                'fe_user'          => $userId,
                'usercourserecord' => $recordId,
                'note'             => $note,
                'file'             => $file,
                'type'             => $type,
                'submitted_at'     => $timestamp,
                'status'           => 'submitted',
                'crdate'           => $timestamp,
                'tstamp'           => $timestamp,
            ]
        );
    }

    public function updateSubmission(
        int $submissionId,
        string $evaluationNote,
        string $evaluationFile,
        string $comment,
        int $evaluatorId,
        int $timestamp
    ): void {
        $this->connection->update(
            'tx_equedlms_domain_model_usersubmission',
            [
                'evaluation_note'    => $evaluationNote,
                'evaluation_file'    => $evaluationFile,
                'instructor_comment' => $comment,
                'evaluated_by'       => $evaluatorId,
                'evaluated_at'       => $timestamp,
                'status'             => 'evaluated',
                'tstamp'             => $timestamp,
            ],
            ['uid' => $submissionId]
        );
    }

    /**
     * Fetch submissions for a frontend user as associative arrays.
     *
     * @param int $feUserId
     * @return array<int, array<string, mixed>>
     */
    public function fetchAllByFeUser(int $feUserId): array
    {
        $qb = $this->connection->createQueryBuilder();
        $qb
            ->select('uid', 'usercourserecord', 'type', 'note', 'file', 'status', 'submitted_at', 'evaluated_at', 'evaluation_note')
            ->from('tx_equedlms_domain_model_usersubmission')
            ->where(
                $qb->expr()->eq('fe_user', $qb->createNamedParameter($feUserId, \PDO::PARAM_INT)),
                $qb->expr()->eq('deleted', 0)
            )
            ->orderBy('submitted_at', 'DESC');

        return $qb->executeQuery()->fetchAllAssociative();
    }

    /**
     * Fetch submissions for a user course record as associative arrays.
     *
     * @param int $recordId
     * @return array<int, array<string, mixed>>
     */
    public function fetchAllByRecord(int $recordId): array
    {
        $qb = $this->connection->createQueryBuilder();
        $qb
            ->select('*')
            ->from('tx_equedlms_domain_model_usersubmission')
            ->where(
                $qb->expr()->eq('usercourserecord', $qb->createNamedParameter($recordId, \PDO::PARAM_INT)),
                $qb->expr()->eq('deleted', 0)
            )
            ->orderBy('submitted_at', 'DESC');

        return $qb->executeQuery()->fetchAllAssociative();
    }
}
