<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;

/**
 * Domain model for quizzes associated with lessons.
 */
final class LessonQuiz extends AbstractEntity
{
    /**
     * The lesson this quiz belongs to.
     */
    #[ManyToOne]
    protected ?Lesson $lesson = null;

    /**
     * Get the lesson.
     */
    public function getLesson(): ?Lesson
    {
        return $this->lesson;
    }

    /**
     * Set the lesson.
     */
    public function setLesson(?Lesson $lesson): void
    {
        $this->lesson = $lesson;
    }
}
