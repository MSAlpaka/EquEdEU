<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Equed\Core\Service\ClockInterface;
use Equed\Core\Service\UuidGeneratorInterface;
use TYPO3\CMS\Extbase\Annotation\Inject;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Domain model for training center feedback.
 */
final class TrainingCenterFeedback extends AbstractEntity
{
    protected string $uuid = '';

    #[Inject]
    protected UuidGeneratorInterface $uuidGenerator;

    #[Inject]
    protected ClockInterface $clock;

    #[ManyToOne]
    #[Lazy]
    protected ?UserCourseRecord $userCourseRecord = null;

    #[ManyToOne]
    #[Lazy]
    protected ?TrainingCenter $trainingCenter = null;

    #[ManyToOne]
    #[Lazy]
    protected ?CourseInstance $courseInstance = null;

    protected int $contentRating = 0;

    protected int $centerRating = 0;

    protected ?string $comment = null;

    protected string $status = 'submitted';

    protected bool $visibleToCenter = true;

    protected bool $visibleToAdmin = true;

    protected string $language = 'en';

    protected bool $isArchived = false;

    protected DateTimeImmutable $createdAt;

    protected DateTimeImmutable $updatedAt;

    /**
     * Initializes UUID and timestamps.
     */
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

    /**
     * Gets the UUID.
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * Gets the user course record.
     */
    public function getUserCourseRecord(): ?UserCourseRecord
    {
        return $this->userCourseRecord;
    }

    /**
     * Sets the user course record.
     *
     * @param UserCourseRecord|null $userCourseRecord
     */
    public function setUserCourseRecord(?UserCourseRecord $userCourseRecord): void
    {
        $this->userCourseRecord = $userCourseRecord;
    }

    /**
     * Gets the training center.
     */
    public function getTrainingCenter(): ?TrainingCenter
    {
        return $this->trainingCenter;
    }

    /**
     * Sets the training center.
     *
     * @param TrainingCenter|null $trainingCenter
     */
    public function setTrainingCenter(?TrainingCenter $trainingCenter): void
    {
        $this->trainingCenter = $trainingCenter;
    }

    /**
     * Gets the course instance.
     */
    public function getCourseInstance(): ?CourseInstance
    {
        return $this->courseInstance;
    }

    /**
     * Sets the course instance.
     *
     * @param CourseInstance|null $courseInstance
     */
    public function setCourseInstance(?CourseInstance $courseInstance): void
    {
        $this->courseInstance = $courseInstance;
    }

    /**
     * Gets the content rating (1–5).
     */
    public function getContentRating(): int
    {
        return $this->contentRating;
    }

    /**
     * Sets the content rating (1–5).
     */
    public function setContentRating(int $contentRating): void
    {
        $this->contentRating = $contentRating;
    }

    /**
     * Gets the center rating (1–5).
     */
    public function getCenterRating(): int
    {
        return $this->centerRating;
    }

    /**
     * Sets the center rating (1–5).
     */
    public function setCenterRating(int $centerRating): void
    {
        $this->centerRating = $centerRating;
    }

    /**
     * Gets the optional comment.
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * Sets the optional comment.
     */
    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * Gets the feedback status.
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Sets the feedback status.
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * Checks if feedback is visible to center.
     */
    public function isVisibleToCenter(): bool
    {
        return $this->visibleToCenter;
    }

    /**
     * Sets visibility to center.
     */
    public function setVisibleToCenter(bool $visibleToCenter): void
    {
        $this->visibleToCenter = $visibleToCenter;
    }

    /**
     * Checks if feedback is visible to admin.
     */
    public function isVisibleToAdmin(): bool
    {
        return $this->visibleToAdmin;
    }

    /**
     * Sets visibility to admin.
     */
    public function setVisibleToAdmin(bool $visibleToAdmin): void
    {
        $this->visibleToAdmin = $visibleToAdmin;
    }

    /**
     * Gets the language code.
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * Sets the language code.
     */
    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }

    /**
     * Checks if archived.
     */
    public function isArchived(): bool
    {
        return $this->isArchived;
    }

    /**
     * Sets archived state.
     */
    public function setIsArchived(bool $isArchived): void
    {
        $this->isArchived = $isArchived;
    }

    /**
     * Gets the creation timestamp.
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Sets the creation timestamp.
     */
    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Gets the last update timestamp.
     */
    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * Sets the last update timestamp.
     */
    public function setUpdatedAt(DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
