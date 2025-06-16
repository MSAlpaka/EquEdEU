<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Service;

use Equed\EquedLms\Domain\Model\LessonProgress;

interface LessonProgressServiceInterface
{
    /**
     * Retrieve progress entry for given user and lesson.
     */
    public function getProgress(int $userId, int $lessonId): ?LessonProgress;

    /**
     * Update or create progress entry for given user and lesson.
     */
    public function setProgress(int $userId, int $lessonId, bool $completed): LessonProgress;
}
