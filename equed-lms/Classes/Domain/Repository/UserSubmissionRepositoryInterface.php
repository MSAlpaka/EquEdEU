<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\Lesson;
use Equed\EquedLms\Domain\Model\PracticeTest;
use Equed\EquedLms\Domain\Model\UserSubmission;
use Equed\EquedLms\Enum\SubmissionStatus;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

interface UserSubmissionRepositoryInterface
{
    /**
     * @return UserSubmission[]
     */
    public function findPendingSubmissionsForInstructor(int $feUserId): array;

    public function countByCourseInstance(int $courseInstanceId): int;

    /**
     * @return UserSubmission[]
     */
    public function findByFeUser(int $feUserId): array;

    /**
     * @return UserSubmission[]
     */
    public function findByCourseInstance(int $courseInstanceId): array;

    public function findByUid(int $uid): ?UserSubmission;

    /**
     * @return UserSubmission[]
     */
    public function findByUserCourseRecord(int $userCourseRecordUid): array;

    /**
     * Fetch earned and maximum points for a UserCourseRecord.
     *
     * @param int $userCourseRecordUid
     * @return array<int, array{points: float|null, maxPoints: float|null}>
     */
    public function findScoresByUserCourseRecord(int $userCourseRecordUid): array;

    /**
     * @return UserSubmission[]
     */
    public function findByLesson(Lesson $lesson): array;

    /**
     * @return UserSubmission[]
     */
    public function findByPracticeTest(PracticeTest $practiceTest): array;

    public function countByLesson(Lesson $lesson): int;

    public function countByPracticeTest(PracticeTest $practiceTest): int;

    /**
     * @param SubmissionStatus|string $status
     * @return UserSubmission[]
     */
    public function findByStatus(SubmissionStatus|string $status): array;

    /**
     * @return UserSubmission[]
     */
    public function findPending(): array;

    public function findLatestByUserCourseRecord(int $userCourseRecordUid): ?UserSubmission;

    /**
     * @return QueryInterface<UserSubmission>
     */
    public function createQuery(): QueryInterface;
}
