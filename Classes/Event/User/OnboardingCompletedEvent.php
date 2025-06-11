<?php

declare(strict_types=1);

namespace Equed\EquedLms\Event;

use DateTimeImmutable;
use Psr\EventDispatcher\StoppableEventInterface;
use Equed\EquedLms\Domain\Model\FrontendUser;

/**
 * Event dispatched when a user completes onboarding.
 */
final class OnboardingCompletedEvent implements StoppableEventInterface
{
    private FrontendUser $user;
    private DateTimeImmutable $completedAt;
    private bool $propagationStopped = false;

    /**
     * @param FrontendUser         $user        The frontend user who completed onboarding
     * @param DateTimeImmutable|null $completedAt Timestamp of completion; defaults to now
     */
    public function __construct(
        FrontendUser $user,
        ?DateTimeImmutable $completedAt = null
    ) {
        $this->user = $user;
        $this->completedAt = $completedAt ?? new DateTimeImmutable();
    }

    /**
     * Get the user who completed onboarding.
     */
    public function getUser(): FrontendUser
    {
        return $this->user;
    }

    /**
     * Get the timestamp when onboarding was completed.
     */
    public function getCompletedAt(): DateTimeImmutable
    {
        return $this->completedAt;
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
