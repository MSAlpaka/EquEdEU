<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\UserProfile;
use Equed\EquedLms\Domain\Repository\UserProfileRepositoryInterface;

/**
 * Service to retrieve instructors and check instructor-course assignments.
 */
final class InstructorService
{
    public function __construct(
        private readonly UserProfileRepositoryInterface $userProfileRepository
    ) {
    }

    /**
     * Retrieve all user profiles marked as instructors.
     *
     * @return UserProfile[]
     */
    public function getInstructors(): array
    {
        return $this->userProfileRepository->findByInstructorStatus(true);
    }

    /**
     * Check if a given instructor (by FE user UID) is assigned to a course instance.
     *
     * @param int $instructorFeUserId Frontend user UID of the instructor
     * @param int $courseInstanceId   UID of the course instance
     * @return bool True if assigned, false otherwise
     */
    public function isAssignedToCourse(int $instructorFeUserId, int $courseInstanceId): bool
    {
        $profile = $this->userProfileRepository->findByFeUser($instructorFeUserId);

        return $profile?->isAssignedToCourseInstance($courseInstanceId) ?? false;
    }
}
