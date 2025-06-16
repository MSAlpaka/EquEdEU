<?php

declare(strict_types=1);

namespace Equed\EquedLms\Event\Progress;

use DateTimeImmutable;
use Equed\EquedLms\Domain\Model\LessonProgress;
use Psr\EventDispatcher\StoppableEventInterface;

/**
 * Event dispatched when a lesson progress entry is completed.
 */
final class LessonProgressCompletedEvent implements StoppableEventInterface
{
    private LessonProgress $lessonProgress;
    private DateTimeImmutable $completedAt;
    private bool $propagationStopped = false;

    public function __construct(LessonProgress $lessonProgress, ?DateTimeImmutable $completedAt = null)
    {
        $this->lessonProgress = $lessonProgress;
        $this->completedAt    = $completedAt ?? new DateTimeImmutable();
    }

    public function getLessonProgress(): LessonProgress
    {
        return $this->lessonProgress;
    }

    public function getCompletedAt(): DateTimeImmutable
    {
        return $this->completedAt;
    }

    public function isPropagationStopped(): bool
    {
        return $this->propagationStopped;
    }

    public function stopPropagation(): void
    {
        $this->propagationStopped = true;
    }
}
// EOF
