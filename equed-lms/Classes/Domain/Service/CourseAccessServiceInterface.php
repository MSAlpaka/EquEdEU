<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Service;

use Equed\EquedLms\Domain\Model\Lesson;

interface CourseAccessServiceInterface
{
    public function hasAccessToCourseInstance(int $feUserId, int $courseInstanceId): bool;

    public function isLessonUnlockedForUser(int $feUserId, Lesson $lesson): bool;
}

