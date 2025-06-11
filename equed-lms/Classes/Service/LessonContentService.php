<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\Lesson;
use Equed\EquedLms\Domain\Repository\LessonRepository;

/**
 * Service for retrieving lesson content.
 */
final class LessonContentService
{
    public function __construct(
        private readonly LessonRepository $lessonRepository
    ) {
    }

    /**
     * Get all visible lessons for a given course program.
     *
     * @param int $courseProgramId ID of the course program
     * @return Lesson[] Array of visible Lesson objects
     */
    public function getVisibleLessonsForCourseProgram(int $courseProgramId): array
    {
        $lessons = $this->lessonRepository->findByCourseProgram($courseProgramId);

        return array_filter(
            $lessons,
            fn (Lesson $lesson): bool => !$lesson->getHidden()
        );
    }
}
