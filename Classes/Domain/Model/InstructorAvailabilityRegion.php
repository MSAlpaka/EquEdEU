<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * InstructorAvailabilityRegion
 *
 * Represents a geographic region where an instructor is available.
 */
final class InstructorAvailabilityRegion extends AbstractEntity
{
    protected string $uuid;

    #[ManyToOne]
    #[Lazy]
    protected ?FrontendUser $instructor = null;

    protected string $regionCode = '';

    protected string $regionLabel = '';

    protected bool $active = true;

    protected DateTimeImmutable $createdAt;

    protected DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $now = new DateTimeImmutable();
        $this->uuid = Uuid::uuid4()->toString();
        $this->createdAt = $now;
        $this->updatedAt = $now;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getInstructor(): ?FrontendUser
    {
        return $this->instructor;
    }

    public function setInstructor(?FrontendUser $instructor): void
    {
        $this->instructor = $instructor;
    }

    public function getRegionCode(): string
    {
        return $this->regionCode;
    }

    public function setRegionCode(string $regionCode): void
    {
        $this->regionCode = $regionCode;
    }

    public function getRegionLabel(): string
    {
        return $this->regionLabel;
    }

    public function setRegionLabel(string $regionLabel): void
    {
        $this->regionLabel = $regionLabel;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
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
