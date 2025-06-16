<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Dto\CourseViewModel;

interface CourseProgressServiceInterface
{
    /**
     * Build the view model for a course progress page.
     *
     * Returns a {@see CourseViewModel} containing either the course data with
     * progress information or an error message.
     */
    public function getCourseViewModel(int $courseUid, int $userId): CourseViewModel;
}
