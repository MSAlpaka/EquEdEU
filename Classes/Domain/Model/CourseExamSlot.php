<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * CourseExamSlot
 *
 * Represents a scheduled exam slot for a course instance.
 */
final class CourseExamSlot extends AbstractEntity
{
    /**
     * Unique identifier
     */
    protected string $uuid;

    #[ManyToOne]
    #[Lazy]
    /**
     * Course instance this exam slot belongs to
     */
    protected ?CourseInstance $courseInstance = null;

    #[ManyToOne]
    #[Lazy]
    /**
     * User acting as examiner
     */
    protected ?FrontendUser $examiner = null;

    /**
     * Start date and time of the exam slot
     */
    protected DateTimeImmutable $startDateTime;

    /**
     * End date and time of the exam slot
     */
    protected DateTimeImmutable $endDateTime;

    /**
     * Location of the exam
     */
    protected string $location = '';

    /**
     * Maximum number of participants
     */
    protected int $capacity = 0;

    /**
     * Already registered participants
     */
    protected int $registeredCount = 0;

    /**
     * Flag if the slot has been cancelled
     */
    protected bool $isCancelled = false;

    /**
     * Creation timestamp
     */
    protected DateTimeImmutable $createdAt;

    /**
     * Last update timestamp
     */
    protected DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $now = new DateTimeImmutable();
        $this->uuid = Uuid::uuid4()->toString();
        $this->startDateTime = $now;
        $this->endDateTime = $now;
        $this->createdAt = $now;
        $this->updatedAt = $now;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getCourseInstance(): ?CourseInstance
    {
        return $this->courseInstance;
    }

    public function setCourseInstance(?CourseInstance $courseInstance): void
    {
        $this->courseInstance = $courseInstance;
    }

    public function getExaminer(): ?FrontendUser
    {
        return $this->examiner;
    }

    public function setExaminer(?FrontendUser $examiner): void
    {
        $this->examiner = $examiner;
    }

    public function getStartDateTime(): DateTimeImmutable
    {
        return $this->startDateTime;
    }

    public function setStartDateTime(DateTimeImmutable $startDateTime): void
    {
        $this->startDateTime = $startDateTime;
    }

    public function getEndDateTime(): DateTimeImmutable
    {
        return $this->endDateTime;
    }

    public function setEndDateTime(DateTimeImmutable $endDateTime): void
    {
        $this->endDateTime = $endDateTime;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function setLocation(string $location): void
    {
        $this->location = $location;
    }

    public function getCapacity(): int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): void
    {
        $this->capacity = $capacity;
    }

    public function getRegisteredCount(): int
    {
        return $this->registeredCount;
    }

    public function setRegisteredCount(int $registeredCount): void
    {
        $this->registeredCount = $registeredCount;
    }

    public function isCancelled(): bool
    {
        return $this->isCancelled;
    }

    public function setIsCancelled(bool $isCancelled): void
    {
        $this->isCancelled = $isCancelled;
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
