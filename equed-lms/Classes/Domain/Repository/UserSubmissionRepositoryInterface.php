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

    /**
     * @param int $courseInstanceId
     * @return int
     */
    public function countByCourseInstance(int $courseInstanceId): int;

    /**
     * @return UserSubmission[]
     */
    public function findByFeUser(int $feUserId): array;

    /**
     * @return UserSubmission[]
     */
    public function findByCourseInstance(int $courseInstanceId): array;

    /**
     * @param int $uid
     * @return UserSubmission|null
     */
    public function findByUid(int $uid): ?UserSubmission;

    /**
     * @param string $uuid
     * @return UserSubmission|null
     */
    public function findByUuid(string $uuid): ?UserSubmission;

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

    /**
     * @param Lesson $lesson
     * @return int
     */
    public function countByLesson(Lesson $lesson): int;

    /**
     * @param PracticeTest $practiceTest
     * @return int
     */
    public function countByPracticeTest(PracticeTest $practiceTest): int;

    /**
     * Count submissions with status "submitted" for the given lesson.
     *
     * @param Lesson $lesson
     * @return int
     */
    public function countSubmittedByLesson(Lesson $lesson): int;

    /**
     * Count all submissions with status "submitted".
     */
    public function countSubmitted(): int;

    /**
     * Count pending submissions for a specific course instance.
     *
     * @param int $courseInstanceId
     * @return int
     */
    public function countPendingByCourseInstance(int $courseInstanceId): int;

    /**
     * Count submissions by status.
     *
     * @param SubmissionStatus|string $status
     * @return int
     */
    public function countByStatus(SubmissionStatus|string $status): int;

    /**
     * @param SubmissionStatus|string $status
     * @return UserSubmission[]
     */
    public function findByStatus(SubmissionStatus|string $status): array;

    /**
     * @return UserSubmission[]
     */
    public function findPending(): array;

    /**
     * @param int $userCourseRecordUid
     * @return UserSubmission|null
     */
    public function findLatestByUserCourseRecord(int $userCourseRecordUid): ?UserSubmission;

    public function createSubmission(
        int $userId,
        int $recordId,
        string $note,
        string $file,
        string $type,
        int $timestamp
    ): void;

    public function updateSubmission(
        int $submissionId,
        string $evaluationNote,
        string $evaluationFile,
        string $comment,
        int $evaluatorId,
        int $timestamp
    ): void;

    /**
     * @return QueryInterface<UserSubmission>
     */
    public function createQuery(): QueryInterface;
}
