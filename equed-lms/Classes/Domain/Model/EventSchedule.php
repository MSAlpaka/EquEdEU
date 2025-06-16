<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * EventSchedule
 *
 * Represents a scheduled course event.
 */
final class EventSchedule extends AbstractEntity
{
    protected string $title = '';

    protected string $description = '';

    protected int $courseInstance = 0;

    protected string $startDatetime = '';

    protected string $endDatetime = '';

    protected int $eventType = 0;

    protected string $location = '';

    protected string $maxParticipants = '';

    protected string $notes = '';

    protected bool $isActive = false;

    protected string $language = '';

    protected string $uuid = '';

    protected string $createdAt = '';

    protected string $updatedAt = '';

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getCourseInstance(): int
    {
        return $this->courseInstance;
    }

    public function setCourseInstance(int $courseInstance): void
    {
        $this->courseInstance = $courseInstance;
    }

    public function getStartDatetime(): string
    {
        return $this->startDatetime;
    }

    public function setStartDatetime(string $startDatetime): void
    {
        $this->startDatetime = $startDatetime;
    }

    public function getEndDatetime(): string
    {
        return $this->endDatetime;
    }

    public function setEndDatetime(string $endDatetime): void
    {
        $this->endDatetime = $endDatetime;
    }

    public function getEventType(): int
    {
        return $this->eventType;
    }

    public function setEventType(int $eventType): void
    {
        $this->eventType = $eventType;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function setLocation(string $location): void
    {
        $this->location = $location;
    }

    public function getMaxParticipants(): string
    {
        return $this->maxParticipants;
    }

    public function setMaxParticipants(string $maxParticipants): void
    {
        $this->maxParticipants = $maxParticipants;
    }

    public function getNotes(): string
    {
        return $this->notes;
    }

    public function setNotes(string $notes): void
    {
        $this->notes = $notes;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
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
