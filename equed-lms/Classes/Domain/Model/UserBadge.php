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
 * Domain model for user badges.
 */
final class UserBadge extends AbstractEntity
{
    protected string $uuid = '';
    #[ManyToOne]
    #[Lazy]
    protected ?FrontendUser $feUser = null;
    protected string $badgeType = '';
    protected ?string $badgeTypeKey = null;
    protected string $source = 'course';
    protected ?string $sourceKey = null;
    protected ?DateTimeImmutable $earnedAt = null;
    protected DateTimeImmutable $createdAt;
    protected DateTimeImmutable $updatedAt;
    /**
     * Initializes UUID and timestamps.
     */
    public function initializeObject(): void
    {
        if ($this->uuid === '') {
            $this->uuid = Uuid::uuid4()->toString();
        }
        $now = new DateTimeImmutable();
        if (!isset($this->createdAt)) {
            $this->createdAt = $now;
        if (!isset($this->updatedAt)) {
            $this->updatedAt = $now;
        if ($this->earnedAt === null) {
            $this->earnedAt = $now;
    }
     * Gets the UUID.
    public function getUuid(): string
        return $this->uuid;
     * Gets the frontend user.
    public function getFeUser(): ?FrontendUser
        return $this->feUser;
     * Sets the frontend user.
     *
     * @param FrontendUser|null $feUser
    public function setFeUser(?FrontendUser $feUser): void
        $this->feUser = $feUser;
     * Gets the badge type.
    public function getBadgeType(): string
        return $this->badgeType;
     * Sets the badge type.
     * @param string $badgeType
    public function setBadgeType(string $badgeType): void
        $this->badgeType = $badgeType;
     * Gets the badge type translation key.
    public function getBadgeTypeKey(): ?string
        return $this->badgeTypeKey;
     * Sets the badge type translation key.
     * @param string|null $badgeTypeKey
    public function setBadgeTypeKey(?string $badgeTypeKey): void
        $this->badgeTypeKey = $badgeTypeKey;
     * Gets the source of badge.
    public function getSource(): string
        return $this->source;
     * Sets the source of badge.
     * @param string $source
    public function setSource(string $source): void
        $this->source = $source;
     * Gets the source translation key.
    public function getSourceKey(): ?string
        return $this->sourceKey;
     * Sets the source translation key.
     * @param string|null $sourceKey
    public function setSourceKey(?string $sourceKey): void
        $this->sourceKey = $sourceKey;
     * Gets the earned timestamp.
    public function getEarnedAt(): ?DateTimeImmutable
        return $this->earnedAt;
     * Sets the earned timestamp.
    public function setEarnedAt(?DateTimeImmutable $earnedAt): void
        $this->earnedAt = $earnedAt;
     * Gets creation timestamp.
    public function getCreatedAt(): DateTimeImmutable
        return $this->createdAt;
     * Sets creation timestamp.
    public function setCreatedAt(DateTimeImmutable $createdAt): void
        $this->createdAt = $createdAt;
     * Gets last update timestamp.
    public function getUpdatedAt(): DateTimeImmutable
        return $this->updatedAt;
     * Sets last update timestamp.
    public function setUpdatedAt(DateTimeImmutable $updatedAt): void
        $this->updatedAt = $updatedAt;
}
