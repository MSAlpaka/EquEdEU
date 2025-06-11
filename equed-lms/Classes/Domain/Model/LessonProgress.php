<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use TYPO3\CMS\Extbase\Annotation\ORM\Cascade;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Represents the progress state of a user for a specific lesson.
 */
final class LessonProgress extends AbstractEntity
{
    /**
     * Frontend user identifier
     */
    protected int $feUser = 0;

    /**
     * Associated lesson
     */
    #[Lazy]
    #[Cascade('remove')]
    protected Lesson $lesson;

    /**
     * Progress percentage (0-100)
     */
    protected int $progress = 0;

    /**
     * Status string (e.g. incomplete, completed)
     */
    protected string $status = 'incomplete';

    protected string $uuid;

    protected DateTimeImmutable $createdAt;

    protected DateTimeImmutable $updatedAt;

    /**
     * Completion status flag
     */
    protected bool $completed = false;

    /**
     * Timestamp when lesson was completed
     */
    protected ?DateTimeImmutable $completedAt = null;

    public function __construct()
    {
        $now = new DateTimeImmutable();
        $this->uuid = Uuid::uuid4()->toString();
        $this->createdAt = $now;
        $this->updatedAt = $now;
    }

    /**
     * Returns the frontend user UID.
     */
    public function getFeUser(): int
    {
        return $this->feUser;
    }

    /**
     * Sets the frontend user UID.
     */
    public function setFeUser(int $feUser): void
    {
        $this->feUser = $feUser;
    }

    /**
     * Returns the associated Lesson.
     */
    public function getLesson(): Lesson
    {
        return $this->lesson;
    }

    /**
     * Sets the associated Lesson.
     */
    public function setLesson(Lesson $lesson): void
    {
        $this->lesson = $lesson;
    }

    /**
     * Returns whether the lesson is completed.
     */
    public function isCompleted(): bool
    {
        return $this->completed;
    }

    /**
     * Sets the completion status.
     */
    public function setCompleted(bool $completed): void
    {
        $this->completed = $completed;
    }

    /**
     * Returns the completion timestamp, or null if not completed.
     */
    public function getCompletedAt(): ?DateTimeImmutable
    {
        return $this->completedAt;
    }

    /**
     * Sets the completion timestamp.
     */
    public function setCompletedAt(?DateTimeImmutable $completedAt): void
    {
        $this->completedAt = $completedAt;
    }

    public function getProgress(): int
    {
        return $this->progress;
    }

    public function setProgress(int $progress): void
    {
        $this->progress = $progress;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
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

    public function getUuid(): string
    {
        return $this->uuid;
    }
}
