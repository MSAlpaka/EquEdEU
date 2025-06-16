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
 * Domain model for standard check answers.
 */
final class StandardCheckAnswer extends AbstractEntity
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
    protected ?StandardCheckItem $standardCheckItem = null;

    protected bool $fulfilled = false;

    protected ?string $comment = null;

    protected bool $isInstructorVisible = true;

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
        if (!isset($this->createdAt)) {
            $now            = $this->clock->now();
            $this->createdAt = $now;
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
     * Gets the standard check item.
     */
    public function getStandardCheckItem(): ?StandardCheckItem
    {
        return $this->standardCheckItem;
    }

    /**
     * Sets the standard check item.
     *
     * @param StandardCheckItem|null $standardCheckItem
     */
    public function setStandardCheckItem(?StandardCheckItem $standardCheckItem): void
    {
        $this->standardCheckItem = $standardCheckItem;
    }

    /**
     * Checks whether the item is fulfilled.
     */
    public function isFulfilled(): bool
    {
        return $this->fulfilled;
    }

    /**
     * Marks the item as fulfilled or not.
     */
    public function setFulfilled(bool $fulfilled): void
    {
        $this->fulfilled = $fulfilled;
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
     * Checks if answer is visible to instructor.
     */
    public function isInstructorVisible(): bool
    {
        return $this->isInstructorVisible;
    }

    /**
     * Sets instructor visibility.
     */
    public function setInstructorVisible(bool $isInstructorVisible): void
    {
        $this->isInstructorVisible = $isInstructorVisible;
    }

    /**
     * Checks if answer is archived.
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
     * Gets creation timestamp.
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Sets creation timestamp.
     */
    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Gets last update timestamp.
     */
    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * Sets last update timestamp.
     */
    public function setUpdatedAt(DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
