<?php

declare(strict_types=1);

namespace Equed\EquedLms\Event\Submission;

use DateTimeImmutable;
use Equed\EquedLms\Domain\Model\UserSubmission;
use Psr\EventDispatcher\StoppableEventInterface;

/**
 * Event dispatched after a user submission file has been uploaded.
 */
final class SubmissionUploadedEvent implements StoppableEventInterface
{
    private UserSubmission $submission;
    private DateTimeImmutable $uploadedAt;
    private bool $propagationStopped = false;

    /**
     * @param UserSubmission         $submission  The user submission entity
     * @param DateTimeImmutable|null $uploadedAt  Timestamp of upload; defaults to now
     */
    public function __construct(
        UserSubmission $submission,
        ?DateTimeImmutable $uploadedAt = null
    ) {
        $this->submission = $submission;
        $this->uploadedAt = $uploadedAt ?? new DateTimeImmutable();
    }

    /**
     * Get the user submission.
     */
    public function getSubmission(): UserSubmission
    {
        return $this->submission;
    }

    /**
     * Get the timestamp when the submission was uploaded.
     */
    public function getUploadedAt(): DateTimeImmutable
    {
        return $this->uploadedAt;
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
