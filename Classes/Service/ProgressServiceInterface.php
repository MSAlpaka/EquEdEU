<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

interface ProgressServiceInterface
{
    /**
     * Returns overall progress data for a user.
     *
     * @param int|\Equed\EquedLms\Domain\Model\FrontendUser $user
     * @return array<string,mixed>
     */
    public function getProgressDataForUser(int|\Equed\EquedLms\Domain\Model\FrontendUser $user): array;

    /**
     * Cleanup progress records older than the given threshold.
     */
    public function cleanupAbandonedCourseProgress(int $days): void;
}
