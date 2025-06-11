<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

final class ExamTemplateCriteria extends AbstractEntity
{
    /** Unique identifier */
    protected string $uuid;

    /** Template this criteria belongs to */
    #[ManyToOne]
    #[Lazy]
    protected ?ExamTemplate $examTemplate = null;

    /** I18n key for criteria title */
    protected string $titleKey = '';

    /** Optional title override */
    protected ?string $titleOverride = null;

    /** Maximum achievable points */
    protected float $maxPoints = 10.0;

    /** Whether this criteria is mandatory */
    protected bool $isRequired = true;

    /** Display order */
    protected int $position = 0;

    /** Archive flag */
    protected bool $isArchived = false;

    /** Creation timestamp */
    protected DateTimeImmutable $createdAt;

    /** Last update timestamp */
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

    public function getExamTemplate(): ?ExamTemplate
    {
        return $this->examTemplate;
    }

    public function setExamTemplate(?ExamTemplate $examTemplate): void
    {
        $this->examTemplate = $examTemplate;
    }

    public function getTitleKey(): string
    {
        return $this->titleKey;
    }

    public function setTitleKey(string $titleKey): void
    {
        $this->titleKey = $titleKey;
    }

    public function getTitleOverride(): ?string
    {
        return $this->titleOverride;
    }

    public function setTitleOverride(?string $titleOverride): void
    {
        $this->titleOverride = $titleOverride;
    }

    public function getMaxPoints(): float
    {
        return $this->maxPoints;
    }

    public function setMaxPoints(float $maxPoints): void
    {
        $this->maxPoints = $maxPoints;
    }

    public function isRequired(): bool
    {
        return $this->isRequired;
    }

    public function setIsRequired(bool $isRequired): void
    {
        $this->isRequired = $isRequired;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): void
    {
        $this->position = $position;
    }

    public function isArchived(): bool
    {
        return $this->isArchived;
    }

    public function setIsArchived(bool $isArchived): void
    {
        $this->isArchived = $isArchived;
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
