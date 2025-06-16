<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Equed\Core\Service\ClockInterface;
use Equed\Core\Service\UuidGeneratorInterface;
use TYPO3\CMS\Extbase\Annotation\Inject;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Annotation\ORM\OneToOne;
use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use Equed\EquedLms\Enum\BadgeLevel;

/**
 * Domain model for user profiles.
 */
final class UserProfile extends AbstractEntity
{
    protected string $uuid = '';

    #[Inject]
    protected UuidGeneratorInterface $uuidGenerator;

    #[Inject]
    protected ClockInterface $clock;

    #[OneToOne(inversedBy: 'userProfile')]
    #[Lazy]
    protected ?FrontendUser $user = null;

    protected string $docuLevel = 'beginner';
    protected ?string $docuLevelKey = null;

    protected int $totalPracticeHours = 0;

    protected int $completedSpecialties = 0;

    protected string $recognitionAward = '';
    protected ?string $recognitionAwardKey = null;

    protected BadgeLevel $badgeLevel = BadgeLevel::None;
    protected ?string $badgeLevelKey = null;

    protected string $profileStatus = 'active';
    protected ?string $profileStatusKey = null;

    protected bool $isVisibleInSearch = false;

    protected bool $hasProAccess = false;

    /**
     * Display name of the user.
     */
    protected string $displayName = '';

    /**
     * Two letter country code of the user.
     */
    protected string $country = '';

    /**
     * Whether the user is marked as instructor.
     */
    protected bool $isInstructor = false;

    /**
     * Whether the user completed onboarding.
     */
    protected bool $onboardingComplete = false;

    protected string $language = 'en';

    protected ?DateTimeImmutable $lastLoginAt = null;

    protected bool $isArchived = false;

    protected DateTimeImmutable $createdAt;
    protected DateTimeImmutable $updatedAt;

    /**
     * Initializes UUID, timestamps and default earnedAt.
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

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function getUser(): ?FrontendUser
    {
        return $this->user;
    }

    public function setUser(?FrontendUser $user): void
    {
        $this->user = $user;
    }

    public function getDocuLevel(): string
    {
        return $this->docuLevel;
    }

    public function setDocuLevel(string $docuLevel): void
    {
        $this->docuLevel = $docuLevel;
    }

    public function getDocuLevelKey(): ?string
    {
        return $this->docuLevelKey;
    }

    public function setDocuLevelKey(?string $docuLevelKey): void
    {
        $this->docuLevelKey = $docuLevelKey;
    }

    public function getTotalPracticeHours(): int
    {
        return $this->totalPracticeHours;
    }

    public function setTotalPracticeHours(int $hours): void
    {
        $this->totalPracticeHours = $hours;
    }

    public function getCompletedSpecialties(): int
    {
        return $this->completedSpecialties;
    }

    public function setCompletedSpecialties(int $count): void
    {
        $this->completedSpecialties = $count;
    }

    public function getRecognitionAward(): string
    {
        return $this->recognitionAward;
    }

    public function setRecognitionAward(string $award): void
    {
        $this->recognitionAward = $award;
    }

    public function getRecognitionAwardKey(): ?string
    {
        return $this->recognitionAwardKey;
    }

    public function setRecognitionAwardKey(?string $recognitionAwardKey): void
    {
        $this->recognitionAwardKey = $recognitionAwardKey;
    }

    public function getBadgeLevel(): BadgeLevel
    {
        return $this->badgeLevel;
    }

    public function setBadgeLevel(BadgeLevel $badgeLevel): void
    {
        $this->badgeLevel = $badgeLevel;
    }

    public function getBadgeLevelKey(): ?string
    {
        return $this->badgeLevelKey;
    }

    public function setBadgeLevelKey(?string $badgeLevelKey): void
    {
        $this->badgeLevelKey = $badgeLevelKey;
    }

    public function getProfileStatus(): string
    {
        return $this->profileStatus;
    }

    public function setProfileStatus(string $status): void
    {
        $this->profileStatus = $status;
    }

    public function getProfileStatusKey(): ?string
    {
        return $this->profileStatusKey;
    }

    public function setProfileStatusKey(?string $profileStatusKey): void
    {
        $this->profileStatusKey = $profileStatusKey;
    }

    public function isVisibleInSearch(): bool
    {
        return $this->isVisibleInSearch;
    }

    public function setIsVisibleInSearch(bool $visible): void
    {
        $this->isVisibleInSearch = $visible;
    }

    public function hasProAccess(): bool
    {
        return $this->hasProAccess;
    }

    public function setHasProAccess(bool $hasAccess): void
    {
        $this->hasProAccess = $hasAccess;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }

    public function getLastLoginAt(): ?DateTimeImmutable
    {
        return $this->lastLoginAt;
    }

    public function setLastLoginAt(?DateTimeImmutable $lastLoginAt): void
    {
        $this->lastLoginAt = $lastLoginAt;
    }

    public function isArchived(): bool
    {
        return $this->isArchived;
    }

    public function setIsArchived(bool $archived): void
    {
        $this->isArchived = $archived;
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

    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    public function setDisplayName(string $displayName): void
    {
        $this->displayName = $displayName;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    public function isInstructor(): bool
    {
        return $this->isInstructor;
    }

    public function getIsInstructor(): bool
    {
        return $this->isInstructor();
    }

    public function setIsInstructor(bool $isInstructor): void
    {
        $this->isInstructor = $isInstructor;
    }

    public function isOnboardingComplete(): bool
    {
        return $this->onboardingComplete;
    }

    public function getOnboardingComplete(): bool
    {
        return $this->onboardingComplete;
    }

    public function setOnboardingComplete(bool $complete): void
    {
        $this->onboardingComplete = $complete;
    }

    public function getFeUser(): ?FrontendUser
    {
        return $this->user;
    }

    public function setFeUser(int $feUserId): void
    {
        if ($this->user === null) {
            $this->user = new FrontendUser();
        }
        $this->user->_setProperty('uid', $feUserId);
    }
}
