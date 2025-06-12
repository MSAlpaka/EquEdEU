<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\UserSubmission;
use Equed\EquedLms\Enum\SubmissionStatus;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository for UserSubmission entities.
 *
 * @extends Repository<UserSubmission>
 */
final class UserSubmissionRepository extends Repository implements UserSubmissionRepositoryInterface
{
    /**
     * Default ordering: newest submissions first.
     *
     * @var array<string,int>
     */
    protected $defaultOrderings = [
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
        $queryBuilder->resetQueryParts();
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
     * @param int $lessonUid
     * @return UserSubmission[]
     */
    public function findByLesson(int $lessonUid): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('lesson', $lessonUid)
        );

        return $query->execute()->toArray();
    }

    /**
     * Find all submissions for a specific practice test.
     *
     * @param int $practiceTestUid
     * @return UserSubmission[]
     */
    public function findByPracticeTest(int $practiceTestUid): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('practiceTest', $practiceTestUid)
        );

        return $query->execute()->toArray();
    }

    /**
     * Count submissions for a specific lesson.
     */
    public function countByLesson(int $lessonUid): int
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('lesson', $lessonUid)
        );

        return $query->execute()->count();
    }

    /**
     * Count submissions for a specific practice test.
     */
    public function countByPracticeTest(int $practiceTestUid): int
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('practiceTest', $practiceTestUid)
        );

        return $query->execute()->count();
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
     */
    public function countByCourseInstance(int $courseInstanceId): int
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('userCourseRecord.courseInstance', $courseInstanceId)
        );

        return $query->execute()->count();
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
     */
    public function findByUid(int $uid): ?UserSubmission
    {
        /** @var UserSubmission|null $result */
        $result = parent::findByUid($uid);

        return $result;
    }
}
// EOF
