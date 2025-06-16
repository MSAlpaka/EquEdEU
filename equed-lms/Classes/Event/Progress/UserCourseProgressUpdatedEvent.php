<?php

declare(strict_types=1);

namespace Equed\EquedLms\Event\Progress;

use DateTimeImmutable;
use Equed\EquedLms\Domain\Model\UserCourseRecord;
use Psr\EventDispatcher\StoppableEventInterface;

/**
 * Event dispatched when a user's course progress has changed.
 */
final class UserCourseProgressUpdatedEvent implements StoppableEventInterface
{
    private UserCourseRecord $userCourseRecord;
    private DateTimeImmutable $updatedAt;
    private bool $propagationStopped = false;

    public function __construct(UserCourseRecord $userCourseRecord, ?DateTimeImmutable $updatedAt = null)
    {
        $this->userCourseRecord = $userCourseRecord;
        $this->updatedAt = $updatedAt ?? new DateTimeImmutable();
    }

    public function getUserCourseRecord(): UserCourseRecord
    {
        return $this->userCourseRecord;
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
