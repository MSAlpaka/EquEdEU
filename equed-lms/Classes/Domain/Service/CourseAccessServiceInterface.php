<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Service;

use Equed\EquedLms\Domain\Model\Lesson;
use Equed\EquedLms\Dto\CourseAccessRequest;
use Equed\EquedLms\Dto\CourseAccessResult;

interface CourseAccessServiceInterface
{
    public function hasAccessToCourseInstance(int $feUserId, int $courseInstanceId): bool;

    public function isLessonUnlockedForUser(int $feUserId, Lesson $lesson): bool;

    /**
     * Check course program access for a user.
     */
    public function checkCourseProgramAccess(CourseAccessRequest $request): CourseAccessResult;
}

