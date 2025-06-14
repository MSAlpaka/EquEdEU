<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;
use Equed\EquedLms\Enum\LanguageCode;

use DateTimeImmutable;
use Equed\Core\Service\ClockInterface;
use TYPO3\CMS\Extbase\Annotation\Inject;
use Ramsey\Uuid\Uuid;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use Equed\EquedLms\Enum\BadgeLevel;

/**
 * BadgeAward
 *
 * Represents an award (badge) granted to a frontend user for a course,
 * specialty, recognition, documentation, or custom criteria.
 */
final class BadgeAward extends AbstractEntity
{
    #[Inject]
    protected ClockInterface $clock;

    /**
     * Unique identifier
     *
     * @var string
     */
    protected string $uuid;

    /**
     * Awarded user
     */
    #[Lazy]
    protected ?FrontendUser $frontendUser = null;

    /**
     * Related course record
     */
    #[Lazy]
    protected ?UserCourseRecord $userCourseRecord = null;

    /**
     * Badge type (course, specialty, ...)
     *
     * @var string
     */
    protected string $badgeType = 'course';

    /**
     * Badge code used for lookups
     *
     * @var string
     */
    protected string $badgeCode = '';

    /**
     * Badge level
     */
    protected BadgeLevel $badgeLevel;

    /**
     * Optional translation key for description
     */
    protected ?string $descriptionKey = null;

    /**
     * Language for description/label
     *
     * @var string
     */
    protected LanguageCode $lang = LanguageCode::EN;

    /**
     * Flag if system automatically awarded the badge
     */
    protected bool $awardedBySystem = true;

    /**
     * User who awarded the badge
     */
    #[Lazy]
    protected ?FrontendUser $awardedBy = null;

    /**
     * Timestamp when badge was awarded
     */
    protected DateTimeImmutable $awardedAt;

    /**
     * Badge validity expiration
     */
    protected ?DateTimeImmutable $validUntil = null;

    /**
     * Creation timestamp
     */
    protected DateTimeImmutable $createdAt;

    /**
     * Last update timestamp
     */
    protected DateTimeImmutable $updatedAt;

    public function __construct(BadgeLevel $initialBadgeLevel)
    {
        $this->uuid       = Uuid::uuid4()->toString();
        $this->badgeLevel = $initialBadgeLevel;
    }

    public function initializeObject(): void
    {
        $now = $this->clock->now();
        if (!isset($this->createdAt)) {
            $this->createdAt = $now;
        }
        if (!isset($this->updatedAt)) {
            $this->updatedAt = $now;
        }
        if (!isset($this->awardedAt)) {
            $this->awardedAt = $now;
        }
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getFrontendUser(): ?FrontendUser
    {
        return $this->frontendUser;
    }

    public function setFrontendUser(?FrontendUser $frontendUser): void
    {
        $this->frontendUser = $frontendUser;
    }

    public function getUserCourseRecord(): ?UserCourseRecord
    {
        return $this->userCourseRecord;
    }

    public function setUserCourseRecord(?UserCourseRecord $userCourseRecord): void
    {
        $this->userCourseRecord = $userCourseRecord;
    }

    public function getBadgeType(): string
    {
        return $this->badgeType;
    }

    public function setBadgeType(string $badgeType): void
    {
        $this->badgeType = $badgeType;
    }

    public function getBadgeCode(): string
    {
        return $this->badgeCode;
    }

    public function setBadgeCode(string $badgeCode): void
    {
        $this->badgeCode = $badgeCode;
    }

    public function getBadgeLevel(): BadgeLevel
    {
        return $this->badgeLevel;
    }

    public function setBadgeLevel(BadgeLevel $badgeLevel): void
    {
        $this->badgeLevel = $badgeLevel;
    }

    public function getDescriptionKey(): ?string
    {
        return $this->descriptionKey;
    }

    public function setDescriptionKey(?string $descriptionKey): void
    {
        $this->descriptionKey = $descriptionKey;
    }

    public function getLang(): LanguageCode
    {
        return $this->lang;
    }

    public function setLang(LanguageCode $lang): void
    {
        $this->lang = $lang;
    }

    public function isAwardedBySystem(): bool
    {
        return $this->awardedBySystem;
    }

    public function setAwardedBySystem(bool $awardedBySystem): void
    {
        $this->awardedBySystem = $awardedBySystem;
    }

    public function getAwardedBy(): ?FrontendUser
    {
        return $this->awardedBy;
    }

    public function setAwardedBy(?FrontendUser $awardedBy): void
    {
        $this->awardedBy = $awardedBy;
    }

    public function getAwardedAt(): DateTimeImmutable
    {
        return $this->awardedAt;
    }

    public function setAwardedAt(DateTimeImmutable $awardedAt): void
    {
        $this->awardedAt = $awardedAt;
    }

    public function getValidUntil(): ?DateTimeImmutable
    {
        return $this->validUntil;
    }

    public function setValidUntil(?DateTimeImmutable $validUntil): void
    {
        $this->validUntil = $validUntil;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
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
