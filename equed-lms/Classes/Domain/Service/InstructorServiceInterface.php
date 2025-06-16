<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Service;

use Equed\EquedLms\Domain\Model\UserProfile;

/**
 * Provides instructor-related operations.
 */
interface InstructorServiceInterface
{
    /**
     * Retrieve all user profiles marked as instructors.
     *
     * @return UserProfile[]
     */
    public function getInstructors(): array;

    /**
     * Check if a given instructor is assigned to a course instance.
     */
    public function isAssignedToCourse(int $instructorFeUserId, int $courseInstanceId): bool;

    /**
     * Mark a user course record as completed by the instructor if allowed.
     */
    public function completeCourse(int $recordId, int $instructorId): bool;

    /**
     * Store an evaluation note for a user course record.
     */
    public function uploadEvaluation(int $recordId, int $instructorId, string $note): bool;
}
