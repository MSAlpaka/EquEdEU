<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Equed\Core\Service\ClockInterface;
use Equed\Core\Service\UuidGeneratorInterface;
use Equed\EquedLms\Enum\UserCourseStatus;
use Equed\EquedLms\Enum\BadgeLevel;
use TYPO3\CMS\Extbase\Annotation\Inject;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Psr\EventDispatcher\EventDispatcherInterface;
use Equed\EquedLms\Event\Course\UserCourseRecordUpdatedEvent;

/**
 * Domain model for user course records.
 */
#[UniqueEntity(fields: ['courseInstance', 'user'])]
final class UserCourseRecord extends AbstractEntity
{
    protected string $uuid = '';

    #[Inject]
    protected UuidGeneratorInterface $uuidGenerator;

    #[Inject]
    protected ClockInterface $clock;

    #[Inject]
    protected EventDispatcherInterface $eventDispatcher;

    #[ManyToOne]
    #[Lazy]
    protected CourseInstance $courseInstance;

    #[ManyToOne]
    #[Lazy]
    protected FrontendUser $user;

    protected int $attemptNumber = 1;

    protected ?DateTimeImmutable $enrolledAt = null;

    protected ?DateTimeImmutable $completedAt = null;

    protected ?DateTimeImmutable $revokedAt = null;

    protected string $certificateNumber = '';

    protected string $certificateHash = '';

    protected BadgeLevel $badgeLevel = BadgeLevel::None;

    /**
     * Status of the course from the user's perspective.
     */
    protected UserCourseStatus $status = UserCourseStatus::InProgress;

    protected bool $finalized = false;

    protected bool $validatedByCertifier = false;

    protected ?DateTimeImmutable $certificateIssuedAt = null;

    /**
     * Percentage progress for the related course instance.
     */
    protected float $progressPercent = 0.0;

    protected ?DateTimeImmutable $lastActivity = null;

    /**
     * Archived attempts as JSON array.
     */
    protected string $archivedAttempts = '[]';

    /**
     * JSON object with module IDs and progress values.
     */
    protected string $passedModules = '{}';

    /**
     * Flag for external certificate replacement.
     */
    protected bool $externalCertificateFlag = false;

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
     * Gets the course instance.
     */
    public function getCourseInstance(): CourseInstance
    {
        return $this->courseInstance;
    }

    /**
     * Sets the course instance.
     *
     * @param CourseInstance $courseInstance
     */
    public function setCourseInstance(CourseInstance $courseInstance): void
    {
        $this->courseInstance = $courseInstance;
    }

    /**
     * Gets the frontend user.
     */
    public function getUser(): FrontendUser
    {
        return $this->user;
    }

    /**
     * Sets the frontend user.
     *
     * @param FrontendUser $user
     */
    public function setUser(FrontendUser $user): void
    {
        $this->user = $user;
    }

    /**
     * Gets the attempt number.
     */
    public function getAttemptNumber(): int
    {
        return $this->attemptNumber;
    }

    /**
     * Sets the attempt number.
     *
     * @param int $attemptNumber
     */
    public function setAttemptNumber(int $attemptNumber): void
    {
        $this->attemptNumber = $attemptNumber;
    }

    /**
     * Gets the course status.
     */
    public function getStatus(): UserCourseStatus
    {
        return $this->status;
    }

    /**
     * Sets the course status.
     *
     * @param UserCourseStatus|string $status
     */
    public function setStatus(UserCourseStatus|string $status): void
    {
        if (is_string($status)) {
            $status = UserCourseStatus::from($status);
        }

        $this->status = $status;
    }

    /**
     * Checks if the record is finalized.
     */
    public function isFinalized(): bool
    {
        return $this->finalized;
    }

    /**
     * Sets the finalized flag.
     *
     * @param bool $finalized
     */
    public function setFinalized(bool $finalized): void
    {
        $this->finalized = $finalized;
    }

    /**
     * Checks if validated by certifier.
     */
    public function isValidatedByCertifier(): bool
    {
        return $this->validatedByCertifier;
    }

    /**
     * Sets the validatedByCertifier flag.
     *
     * @param bool $validatedByCertifier
     */
    public function setValidatedByCertifier(bool $validatedByCertifier): void
    {
        $this->validatedByCertifier = $validatedByCertifier;
    }

    /**
     * Gets the certificate issuance timestamp.
     */
    public function getCertificateIssuedAt(): ?DateTimeImmutable
    {
        return $this->certificateIssuedAt;
    }

    /**
     * Sets the certificate issuance timestamp.
     *
     * @param DateTimeImmutable|null $certificateIssuedAt
     */
    public function setCertificateIssuedAt(?DateTimeImmutable $certificateIssuedAt): void
    {
        $this->certificateIssuedAt = $certificateIssuedAt;
    }

    public function getEnrolledAt(): ?DateTimeImmutable
    {
        return $this->enrolledAt;
    }

    public function setEnrolledAt(?DateTimeImmutable $enrolledAt): void
    {
        $this->enrolledAt = $enrolledAt;
    }

    public function getCompletedAt(): ?DateTimeImmutable
    {
        return $this->completedAt;
    }

    public function setCompletedAt(?DateTimeImmutable $completedAt): void
    {
        $this->completedAt = $completedAt;
        $this->eventDispatcher->dispatch(
            new UserCourseRecordUpdatedEvent($this, 'completedAt')
        );
    }

    /**
     * Convenience check whether the course was completed.
     */
    public function isCompleted(): bool
    {
        return $this->completedAt !== null;
    }

    /**
     * Alias setter for backwards compatibility.
     */
    public function setCompleted(bool $completed): void
    {
        $this->completedAt = $completed ? ($this->completedAt ?? new DateTimeImmutable()) : null;
    }

    /**
     * Alias getter for the completion timestamp.
     */
    public function getCompletionDate(): ?DateTimeImmutable
    {
        return $this->completedAt;
    }

    /**
     * Alias setter for the completion timestamp.
     */
    public function setCompletionDate(?DateTimeImmutable $completionDate): void
    {
        $this->completedAt = $completionDate;
    }

    public function getRevokedAt(): ?DateTimeImmutable
    {
        return $this->revokedAt;
    }

    public function setRevokedAt(?DateTimeImmutable $revokedAt): void
    {
        $this->revokedAt = $revokedAt;
    }

    public function getCertificateNumber(): string
    {
        return $this->certificateNumber;
    }

    public function setCertificateNumber(string $certificateNumber): void
    {
        $this->certificateNumber = $certificateNumber;
    }

    public function getCertificateHash(): string
    {
        return $this->certificateHash;
    }

    public function setCertificateHash(string $certificateHash): void
    {
        $this->certificateHash = $certificateHash;
    }

    public function getBadgeLevel(): BadgeLevel
    {
        return $this->badgeLevel;
    }

    public function setBadgeLevel(BadgeLevel $badgeLevel): void
    {
        $this->badgeLevel = $badgeLevel;
        $this->eventDispatcher->dispatch(
            new UserCourseRecordUpdatedEvent($this, 'badgeLevel')
        );
    }

    public function getProgressPercent(): float
    {
        return $this->progressPercent;
    }

    public function setProgressPercent(float $progressPercent): void
    {
        $this->progressPercent = $progressPercent;
        $this->eventDispatcher->dispatch(
            new UserCourseRecordUpdatedEvent($this, 'progressPercent')
        );
    }

    public function getLastActivity(): ?DateTimeImmutable
    {
        return $this->lastActivity;
    }

    public function setLastActivity(?DateTimeImmutable $lastActivity): void
    {
        $this->lastActivity = $lastActivity;
        $this->eventDispatcher->dispatch(
            new UserCourseRecordUpdatedEvent($this, 'lastActivity')
        );
    }

    public function hasBadge(): bool
    {
        return $this->badgeLevel !== BadgeLevel::None;
    }

    public function getBadgeIconUrl(): ?string
    {
        $program = $this->courseInstance->getCourseProgram();
        $fileRef = $program?->getBadgeIcon();

        return $fileRef?->getOriginalResource()->getPublicUrl();
    }

    /**
     * Gets archived attempts JSON.
     */
    public function getArchivedAttempts(): string
    {
        return $this->archivedAttempts;
    }

    /**
     * Sets archived attempts JSON.
     *
     * @param string $archivedAttempts
     */
    public function setArchivedAttempts(string $archivedAttempts): void
    {
        $this->archivedAttempts = $archivedAttempts;
    }

    /**
     * Gets passed modules JSON.
     */
    public function getPassedModules(): string
    {
        return $this->passedModules;
    }

    /**
     * Sets passed modules JSON.
     *
     * @param string $passedModules
     */
    public function setPassedModules(string $passedModules): void
    {
        $this->passedModules = $passedModules;
    }

    /**
     * Checks if an external certificate flag is set.
     */
    public function isExternalCertificateFlag(): bool
    {
        return $this->externalCertificateFlag;
    }

    /**
     * Sets the external certificate flag.
     *
     * @param bool $externalCertificateFlag
     */
    public function setExternalCertificateFlag(bool $externalCertificateFlag): void
    {
        $this->externalCertificateFlag = $externalCertificateFlag;
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
     *
     * @param DateTimeImmutable $createdAt
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
     *
     * @param DateTimeImmutable $updatedAt
     */
    public function setUpdatedAt(DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
