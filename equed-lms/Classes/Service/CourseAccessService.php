<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\Lesson;
use Equed\EquedLms\Domain\Model\UserCourseRecord;
use Equed\EquedLms\Domain\Repository\UserCourseRecordRepositoryInterface;

/**
 * Service to check access permissions for courses and lessons.
 */
final class CourseAccessService
{
    private array $userRecordsCache = [];

    public function __construct(
        private readonly UserCourseRecordRepositoryInterface $userCourseRecordRepository
    ) {
    }

    /**
     * Check if a frontend user has access to a specific course instance.
     *
     * @param int $feUserId Frontend user UID
     * @param int $courseInstanceId Course instance UID
     * @return bool True if access is granted, false otherwise
     */
    public function hasAccessToCourseInstance(int $feUserId, int $courseInstanceId): bool
    {
        foreach ($this->getUserCourseRecords($feUserId) as $record) {
            if ($record->getCourseInstance()?->getUid() === $courseInstanceId) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if a lesson is unlocked for a frontend user based on the lesson's course program.
     *
     * @param int    $feUserId Frontend user UID
     * @param Lesson $lesson   Lesson model
     * @return bool True if the lesson is unlocked, false otherwise
     */
    public function isLessonUnlockedForUser(int $feUserId, Lesson $lesson): bool
    {
        $programId = $lesson->getCourseProgram()->getUid();

        foreach ($this->getUserCourseRecords($feUserId) as $record) {
            $courseProgram = $record->getCourseInstance()?->getCourseProgram();

            if ($courseProgram?->getUid() === $programId) {
                return true;
            }
        }

        return false;
    }

    /**
     * Retrieve and cache UserCourseRecord entities for a frontend user.
     *
     * @param int $feUserId Frontend user UID
     * @return UserCourseRecord[] Array of UserCourseRecord
     */
    private function getUserCourseRecords(int $feUserId): array
    {
        if (!isset($this->userRecordsCache[$feUserId])) {
            $this->userRecordsCache[$feUserId] = $this->userCourseRecordRepository->findByFeUser($feUserId);
        }

        return $this->userRecordsCache[$feUserId];
    }
}
