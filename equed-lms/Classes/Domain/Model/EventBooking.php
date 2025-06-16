<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * EventBooking
 *
 * Represents a user booking for an event schedule.
 */
final class EventBooking extends AbstractEntity
{
    protected int $user = 0;

    protected int $eventSchedule = 0;

    protected int $bookingStatus = 0;

    protected string $comment = '';

    protected bool $confirmedByInstructor = false;

    protected string $confirmationDatetime = '';

    protected string $cancelledReason = '';

    protected string $language = '';

    protected string $uuid = '';

    protected string $createdAt = '';

    protected string $updatedAt = '';

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

    public function getConfirmationDatetime(): string
    {
        return $this->confirmationDatetime;
    }

    public function setConfirmationDatetime(string $confirmationDatetime): void
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

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
