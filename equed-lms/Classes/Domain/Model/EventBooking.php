<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Equed\Core\Service\ClockInterface;
use Equed\Core\Service\UuidGeneratorInterface;
use Equed\EquedLms\Enum\LanguageCode;
use Equed\EquedLms\Enum\EventBookingStatus;
use TYPO3\CMS\Extbase\Annotation\Inject;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * EventBooking
 *
 * Represents a user booking for an event schedule.
 */
final class EventBooking extends AbstractEntity
{
    #[Inject]
    protected ClockInterface $clock;

    #[Inject]
    protected UuidGeneratorInterface $uuidGenerator;

    protected int $user = 0;

    protected int $eventSchedule = 0;

    protected EventBookingStatus $bookingStatus = EventBookingStatus::Pending;

    protected string $comment = '';

    protected bool $confirmedByInstructor = false;

    protected ?DateTimeImmutable $confirmationDatetime = null;

    protected string $cancelledReason = '';

    protected LanguageCode $language = LanguageCode::EN;

    protected string $uuid = '';

    protected DateTimeImmutable $createdAt;

    protected DateTimeImmutable $updatedAt;

    public function initializeObject(): void
    {
        if ($this->uuid === '') {
            $this->uuid = $this->uuidGenerator->generate();
        }
        $now = $this->clock->now();

        if (!isset($this->createdAt)) {
            $this->createdAt = $now;
        }

        if (!isset($this->updatedAt)) {
            $this->updatedAt = $now;
        }
    }

    public function getUser(): int
    {
        return $this->user;
    }

    public function setUser(int $user): void
    {
        $this->user = $user;
    }

    public function getEventSchedule(): int
    {
        return $this->eventSchedule;
    }

    public function setEventSchedule(int $eventSchedule): void
    {
        $this->eventSchedule = $eventSchedule;
    }

    public function getBookingStatus(): EventBookingStatus
    {
        return $this->bookingStatus;
    }

    public function setBookingStatus(EventBookingStatus|string $bookingStatus): void
    {
        if (is_string($bookingStatus)) {
            $bookingStatus = EventBookingStatus::from($bookingStatus);
        }

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

    public function getLanguage(): LanguageCode
    {
        return $this->language;
    }

    public function setLanguage(LanguageCode $language): void
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
