<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use TYPO3\CMS\Extbase\Annotation\ORM\Cascade;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use Equed\EquedLms\Enum\ProgressStatus;
use Equed\EquedLms\Domain\Model\UserCourseRecord;

/**
 * Represents the progress state of a user for a specific lesson.
 */
final class LessonProgress extends AbstractEntity
{

    #[ManyToOne]
    #[Lazy]
    protected ?UserCourseRecord $userCourseRecord = null;

    /**
     * Associated lesson
     */
    #[ManyToOne]
    #[Lazy]
    #[Cascade('remove')]
    protected Lesson $lesson;

    /**
     * Progress percentage (0-100)
     */
    protected int $progress = 0;

    /**
     * Status of the lesson progress.
     */
    protected ProgressStatus $status = ProgressStatus::NotStarted;

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


    public function getUserCourseRecord(): ?UserCourseRecord
    {
        return $this->userCourseRecord;
    }

    public function setUserCourseRecord(?UserCourseRecord $userCourseRecord): void
    {
        $this->userCourseRecord = $userCourseRecord;
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

    public function getStatus(): ProgressStatus
    {
        return $this->status;
    }

    public function setStatus(ProgressStatus|string $status): void
    {
        if (is_string($status)) {
            $status = ProgressStatus::from($status);
        }

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
