<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\UserCourseRecord;
use Equed\EquedLms\Domain\Repository\UserCourseRecordRepositoryInterface;

/**
 * Service for retrieving user course records and statuses.
 */
final class UserCourseService
{
    public function __construct(
        private readonly UserCourseRecordRepositoryInterface $userCourseRecordRepository
    ) {
    }

    /**
     * Check if a specific course instance is active for a user.
     *
     * @param int $userId            ID of the frontend user
     * @param int $courseInstanceId  UID of the course instance
     * @return bool True if the user has an active record for the instance
     */
    public function isCourseActive(int $userId, int $courseInstanceId): bool
    {
        return $this->userCourseRecordRepository->countByUserAndInstanceAndStatus(
            $userId,
            $courseInstanceId,
            'active'
        ) > 0;
    }

    /**
     * Get all currently active courses for a user.
     *
     * @param int $userId ID of the frontend user
     * @return UserCourseRecord[] Array of active UserCourseRecord objects
     */
    public function getCurrentCourses(int $userId): array
    {
        return $this->userCourseRecordRepository->findByUserAndStatus(
            $userId,
            'active'
        );
    }

    /**
     * Get all completed courses for a user.
     *
     * @param int $userId ID of the frontend user
     * @return UserCourseRecord[] Array of completed UserCourseRecord objects
     */
    public function getCompletedCourses(int $userId): array
    {
        return $this->userCourseRecordRepository->findByUserAndStatus(
            $userId,
            'completed'
        );
    }
}
