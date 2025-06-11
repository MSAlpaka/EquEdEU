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
class UserSubmissionRepository extends Repository
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
}
// EOF
