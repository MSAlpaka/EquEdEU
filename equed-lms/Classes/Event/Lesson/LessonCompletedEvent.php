<?php

declare(strict_types=1);

namespace Equed\EquedLms\Event\Lesson;

use Equed\EquedLms\Domain\Model\LessonProgress;

/**
 * Event dispatched when a lesson is completed.
 */
final class LessonCompletedEvent
{
    public function __construct(
        private readonly LessonProgress $lessonProgress
    ) {
    }

    /**
     * Returns the completed lesson progress entity.
     */
    public function getLessonProgress(): LessonProgress
    {
        return $this->lessonProgress;
    }
}

