<?php

declare(strict_types=1);

namespace Equed\EquedLms\Event\Progress;

use DateTimeImmutable;
use Equed\EquedLms\Domain\Model\LessonProgress;
use Psr\EventDispatcher\StoppableEventInterface;

/**
 * Event dispatched when a lesson progress entry is updated.
 */
final class LessonProgressUpdatedEvent implements StoppableEventInterface
{
    private LessonProgress $lessonProgress;
    private DateTimeImmutable $updatedAt;
    private bool $propagationStopped = false;

    public function __construct(LessonProgress $lessonProgress, ?DateTimeImmutable $updatedAt = null)
    {
        $this->lessonProgress = $lessonProgress;
        $this->updatedAt = $updatedAt ?? new DateTimeImmutable();
    }

    public function getLessonProgress(): LessonProgress
    {
        return $this->lessonProgress;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
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
