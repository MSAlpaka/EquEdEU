<?php

declare(strict_types=1);

namespace Equed\EquedLms\Event\Course;

use DateTimeImmutable;
use Equed\EquedLms\Domain\Model\UserCourseRecord;
use Psr\EventDispatcher\StoppableEventInterface;

/**
 * Event dispatched when a course completion has been validated.
 */
final class CourseCompletionValidatedEvent implements StoppableEventInterface
{
    private UserCourseRecord $userCourseRecord;
    private DateTimeImmutable $validatedAt;
    private bool $propagationStopped = false;

    /**
     * @param UserCourseRecord       $userCourseRecord The user course record that was validated
     * @param DateTimeImmutable|null $validatedAt      The timestamp of validation; defaults to now
     */
    public function __construct(
        UserCourseRecord $userCourseRecord,
        ?DateTimeImmutable $validatedAt = null
    ) {
        $this->userCourseRecord = $userCourseRecord;
        $this->validatedAt = $validatedAt ?? new DateTimeImmutable();
    }

    /**
     * Get the validated UserCourseRecord.
     */
    public function getUserCourseRecord(): UserCourseRecord
    {
        return $this->userCourseRecord;
    }

    /**
     * Get the timestamp when validation occurred.
     */
    public function getValidatedAt(): DateTimeImmutable
    {
        return $this->validatedAt;
    }

    /**
     * {@inheritDoc}
     */
    public function isPropagationStopped(): bool
    {
        return $this->propagationStopped;
    }

    /**
     * Stop further propagation of this event.
     */
    public function stopPropagation(): void
    {
        $this->propagationStopped = true;
    }
}
// EOF
