<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Service;

/**
 * Provides instructor specific dashboard data.
 */
interface InstructorDashboardServiceInterface
{
    /**
     * Check whether the given user is an instructor.
     */
    public function isInstructor(int $userId): bool;

    /**
     * Get course instances assigned to the instructor.
     *
     * @return array<int, mixed>
     */
    public function getInstructorInstances(int $instructorId): array;

    /**
     * Get participants (user course records) for the instructor.
     *
     * @return array<int, mixed>
     */
    public function getInstructorParticipants(int $instructorId): array;
}
