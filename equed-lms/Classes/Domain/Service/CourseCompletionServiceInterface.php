<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Service;

interface CourseCompletionServiceInterface
{
    /**
     * Marks a user's course record as completed if not already done.
     *
     * @param int $feUserId  Frontend user UID
     * @param int $courseUid Course UID
     * @return bool True if the record was newly marked completed, false otherwise
     */
    public function markCompletedIfNotYet(int $feUserId, int $courseUid): bool;
}
