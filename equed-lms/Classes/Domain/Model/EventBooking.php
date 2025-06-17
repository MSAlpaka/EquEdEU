<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Domain\Model\EventSchedule;
use Equed\EquedLms\Domain\Model\Traits\PersistenceTrait;

/**
 * EventBooking
 *
 * Represents a user booking for an event schedule.
 */
final class EventBooking extends AbstractEntity
{
    use PersistenceTrait;

    #[ManyToOne]
    #[Lazy]
    protected ?FrontendUser $user = null;

    #[ManyToOne]
    #[Lazy]
    protected ?EventSchedule $eventSchedule = null;

    protected int $bookingStatus = 0;

    protected string $comment = '';

    protected bool $confirmedByInstructor = false;

    protected ?DateTimeImmutable $confirmationDatetime = null;

    protected string $cancelledReason = '';

    protected string $language = '';

    public function initializeObject(): void
    {
        $this->initializePersistenceTrait();
    }

    public function getUser(): ?FrontendUser
    {
        return $this->user;
    }

    public function setUser(?FrontendUser $user): void
    {
        $this->user = $user;
    }

    public function getEventSchedule(): ?EventSchedule
    {
        return $this->eventSchedule;
    }

    public function setEventSchedule(?EventSchedule $eventSchedule): void
    {
        $this->eventSchedule = $eventSchedule;
    }

    public function getBookingStatus(): int
    {
        return $this->bookingStatus;
    }

    public function setBookingStatus(int $bookingStatus): void
    {
        $this->bookingStatus = $bookingStatus;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    public function isConfirmedByInstructor(): bool
    {
        return $this->confirmedByInstructor;
    }

    public function setConfirmedByInstructor(bool $confirmedByInstructor): void
    {
        $this->confirmedByInstructor = $confirmedByInstructor;
    }

    public function getConfirmationDatetime(): ?DateTimeImmutable
    {
        return $this->confirmationDatetime;
    }

    public function setConfirmationDatetime(?DateTimeImmutable $confirmationDatetime): void
    {
        $this->confirmationDatetime = $confirmationDatetime;
    }

    public function getCancelledReason(): string
    {
        return $this->cancelledReason;
    }

    public function setCancelledReason(string $cancelledReason): void
    {
        $this->cancelledReason = $cancelledReason;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
