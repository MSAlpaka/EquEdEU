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
 * Domain model for recognition awards.
 */
final class RecognitionAward extends AbstractEntity
{
    protected string $uuid = '';
    #[ManyToOne]
    #[Lazy]
    protected ?FrontendUser $feUser = null;
    protected string $awardType = '';
    protected ?string $awardTypeKey = null;
    protected string $criteriaSummary = '';
    protected ?string $criteriaSummaryKey = null;
    protected ?DateTimeImmutable $grantedAt = null;
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
        if (!isset($this->createdAt)) {
            $now = new DateTimeImmutable();
            $this->createdAt = $now;
            $this->updatedAt = $now;
    }
     * Gets the UUID.
    public function getUuid(): string
        return $this->uuid;
     * Gets the frontend user.
    public function getFeUser(): ?FrontendUser
        return $this->feUser;
     * Sets the frontend user.
    public function setFeUser(?FrontendUser $feUser): void
        $this->feUser = $feUser;
     * Gets the award type.
    public function getAwardType(): string
        return $this->awardType;
     * Sets the award type.
    public function setAwardType(string $awardType): void
        $this->awardType = $awardType;
     * Gets the award type translation key.
    public function getAwardTypeKey(): ?string
        return $this->awardTypeKey;
     * Sets the award type translation key.
    public function setAwardTypeKey(?string $awardTypeKey): void
        $this->awardTypeKey = $awardTypeKey;
     * Gets the criteria summary.
    public function getCriteriaSummary(): string
        return $this->criteriaSummary;
     * Sets the criteria summary.
    public function setCriteriaSummary(string $criteriaSummary): void
        $this->criteriaSummary = $criteriaSummary;
     * Gets the criteria summary translation key.
    public function getCriteriaSummaryKey(): ?string
        return $this->criteriaSummaryKey;
     * Sets the criteria summary translation key.
    public function setCriteriaSummaryKey(?string $criteriaSummaryKey): void
        $this->criteriaSummaryKey = $criteriaSummaryKey;
     * Gets the granted timestamp.
    public function getGrantedAt(): ?DateTimeImmutable
        return $this->grantedAt;
     * Sets the granted timestamp.
    public function setGrantedAt(?DateTimeImmutable $grantedAt): void
        $this->grantedAt = $grantedAt;
     * Gets the creation timestamp.
    public function getCreatedAt(): DateTimeImmutable
        return $this->createdAt;
     * Sets the creation timestamp.
    public function setCreatedAt(DateTimeImmutable $createdAt): void
        $this->createdAt = $createdAt;
     * Gets the last update timestamp.
    public function getUpdatedAt(): DateTimeImmutable
        return $this->updatedAt;
     * Sets the last update timestamp.
    public function setUpdatedAt(DateTimeImmutable $updatedAt): void
        $this->updatedAt = $updatedAt;
}
