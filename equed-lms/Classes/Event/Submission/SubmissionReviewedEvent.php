<?php

declare(strict_types=1);

namespace Equed\EquedLms\Event\Submission;

use DateTimeImmutable;
use Equed\EquedLms\Domain\Model\UserSubmission;
use Psr\EventDispatcher\StoppableEventInterface;

/**
 * Event dispatched when a user submission has been reviewed.
 */
final class SubmissionReviewedEvent implements StoppableEventInterface
{
    private UserSubmission $submission;
    private DateTimeImmutable $reviewedAt;
    private bool $propagationStopped = false;

    public function __construct(UserSubmission $submission, ?DateTimeImmutable $reviewedAt = null)
    {
        $this->submission = $submission;
        $this->reviewedAt = $reviewedAt ?? new DateTimeImmutable();
    }

    public function getSubmission(): UserSubmission
    {
        return $this->submission;
    }

    public function getReviewedAt(): DateTimeImmutable
    {
        return $this->reviewedAt;
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
