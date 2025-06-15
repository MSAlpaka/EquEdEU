<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Service;

/**
 * Provides program and course overview data for frontend users.
 */
interface CourseOverviewServiceInterface
{
    /**
     * Returns visible and active course programs.
     *
     * @return array<int, mixed>
     */
    public function getAvailablePrograms(): array;

    /**
     * Returns active course instances.
     *
     * @return array<int, mixed>
     */
    public function getActiveInstances(): array;

    /**
     * Returns course records for the given user.
     *
     * @param int $userId Frontend user UID
     * @return array<int, mixed>
     */
    public function getMyCourses(int $userId): array;

    /**
     * Assemble complete overview data.
     *
     * @param int $userId Frontend user UID
     * @return array<string, mixed>
     */
    public function getCourseOverview(int $userId): array;
}

