<?php

declare(strict_types=1);
namespace Equed\EquedLms\Domain\Model;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Equed\EquedLms\Enum\LanguageCode;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
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
    #[ManyToOne]
    #[Lazy]
    protected ?CourseInstance $courseInstance = null;
    protected DateTimeImmutable $startDatetime;
    protected DateTimeImmutable $endDatetime;
    protected int $eventType = 0;
    protected string $location = '';
    protected int $maxParticipants = 0;
    protected string $notes = '';
    protected bool $isActive = false;
    protected LanguageCode $language = LanguageCode::EN;
    protected string $uuid = '';
    protected DateTimeImmutable $createdAt;
    protected DateTimeImmutable $updatedAt;
    public function initializeObject(): void
    {
        $now = new DateTimeImmutable();
        if (!isset($this->createdAt)) {
            $this->createdAt = $now;
        }
        if (!isset($this->updatedAt)) {
            $this->updatedAt = $now;
        if (!isset($this->startDatetime)) {
            $this->startDatetime = $now;
        if (!isset($this->endDatetime)) {
            $this->endDatetime = $now;
    }
    public function getTitle(): string
        return $this->title;
    public function setTitle(string $title): void
        $this->title = $title;
    public function getDescription(): string
        return $this->description;
    public function setDescription(string $description): void
        $this->description = $description;
    public function getCourseInstance(): ?CourseInstance
        return $this->courseInstance;
    public function setCourseInstance(?CourseInstance $courseInstance): void
        $this->courseInstance = $courseInstance;
    public function getStartDatetime(): DateTimeImmutable
        return $this->startDatetime;
    public function setStartDatetime(DateTimeImmutable $startDatetime): void
        $this->startDatetime = $startDatetime;
    public function getEndDatetime(): DateTimeImmutable
        return $this->endDatetime;
    public function setEndDatetime(DateTimeImmutable $endDatetime): void
        $this->endDatetime = $endDatetime;
    public function getEventType(): int
        return $this->eventType;
    public function setEventType(int $eventType): void
        $this->eventType = $eventType;
    public function getLocation(): string
        return $this->location;
    public function setLocation(string $location): void
        $this->location = $location;
    public function getMaxParticipants(): int
        return $this->maxParticipants;
    public function setMaxParticipants(int $maxParticipants): void
        $this->maxParticipants = $maxParticipants;
    public function getNotes(): string
        return $this->notes;
    public function setNotes(string $notes): void
        $this->notes = $notes;
    public function isActive(): bool
        return $this->isActive;
    public function setIsActive(bool $isActive): void
        $this->isActive = $isActive;
    public function getLanguage(): LanguageCode
        return $this->language;
    public function setLanguage(LanguageCode $language): void
        $this->language = $language;
    public function getUuid(): string
        return $this->uuid;
    public function setUuid(string $uuid): void
        $this->uuid = $uuid;
    public function getCreatedAt(): DateTimeImmutable
        return $this->createdAt;
    public function setCreatedAt(DateTimeImmutable $createdAt): void
        $this->createdAt = $createdAt;
    public function getUpdatedAt(): DateTimeImmutable
        return $this->updatedAt;
    public function setUpdatedAt(DateTimeImmutable $updatedAt): void
        $this->updatedAt = $updatedAt;
}
