<?php

declare(strict_types=1);

namespace Equed\EquedLms\Event\Qms;

use DateTimeImmutable;
use Equed\EquedLms\Domain\Model\QmsCase;
use Psr\EventDispatcher\StoppableEventInterface;

/**
 * Event dispatched when a QMS case is escalated.
 */
final class QmsCaseEscalatedEvent implements StoppableEventInterface
{
    private QmsCase $qmsCase;
    private DateTimeImmutable $escalatedAt;
    private bool $propagationStopped = false;

    /**
     * @param QmsCase               $qmsCase      The QMS case that was escalated
     * @param DateTimeImmutable|null $escalatedAt  The timestamp of escalation; defaults to now
     */
    public function __construct(
        QmsCase $qmsCase,
        ?DateTimeImmutable $escalatedAt = null
    ) {
        $this->qmsCase = $qmsCase;
        $this->escalatedAt = $escalatedAt ?? new DateTimeImmutable();
    }

    /**
     * Get the escalated QMS case.
     */
    public function getQmsCase(): QmsCase
    {
        return $this->qmsCase;
    }

    /**
     * Get the timestamp when escalation occurred.
     */
    public function getEscalatedAt(): DateTimeImmutable
    {
        return $this->escalatedAt;
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
