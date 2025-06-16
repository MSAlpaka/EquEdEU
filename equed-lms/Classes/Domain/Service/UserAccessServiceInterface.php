<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Service;

/**
 * Provides access checks for users and instructors.
 */
interface UserAccessServiceInterface
{
    /**
     * Check if a user has access to a specific course program.
     */
    public function canAccessCourse(int $userId, int $courseProgramId): bool;

    /**
     * Check if the given user is the instructor for a specific course record.
     */
    public function canValidateAsInstructor(int $instructorUserId, int $userCourseRecordId): bool;
}
