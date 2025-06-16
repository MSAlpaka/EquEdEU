<?php

declare(strict_types=1);

namespace Equed\EquedLms\Event\Submission;

use DateTimeImmutable;
use Equed\EquedLms\Domain\Model\Submission;
use Psr\EventDispatcher\StoppableEventInterface;

/**
 * Event dispatched when a submission has been analyzed via GPT.
 */
final class SubmissionAnalyzedEvent implements StoppableEventInterface
{
    private Submission $submission;
    private DateTimeImmutable $analyzedAt;
    private bool $propagationStopped = false;

    public function __construct(Submission $submission, ?DateTimeImmutable $analyzedAt = null)
    {
        $this->submission = $submission;
        $this->analyzedAt = $analyzedAt ?? new DateTimeImmutable();
    }

    public function getSubmission(): Submission
    {
        return $this->submission;
    }

    public function getAnalyzedAt(): DateTimeImmutable
    {
        return $this->analyzedAt;
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
