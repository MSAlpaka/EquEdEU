<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

interface CourseProgressServiceInterface
{
    /**
     * Build the view model for a course progress page.
     *
     * The returned array either contains an 'error' key with a localized
     * message or the keys 'course', 'lessons', 'progressPercent' and 'userId'.
     *
     * @param int $courseUid Course identifier
     * @param int $userId    Frontend user identifier
     * @return array<string,mixed>
     */
    public function getCourseViewModel(int $courseUid, int $userId): array;
}
