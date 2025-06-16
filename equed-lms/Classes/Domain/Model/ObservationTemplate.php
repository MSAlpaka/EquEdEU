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
use Equed\EquedLms\Domain\Model\CourseProgram;

/**
 * Domain model for observation templates.
 */
final class ObservationTemplate extends AbstractEntity
{
    protected string $uuid = '';

    #[Inject]
    protected UuidGeneratorInterface $uuidGenerator;

    #[Inject]
    protected ClockInterface $clock;

    protected string $title = '';

    protected ?string $titleKey = null;

    protected ?string $description = null;

    protected ?string $structure = null;

    #[ManyToOne]
    #[Lazy]
    protected ?CourseProgram $courseProgram = null;

    protected bool $isActive = true;

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

        if (!isset($this->createdAt)) {
            $now = $this->clock->now();
            $this->createdAt = $now;
            $this->updatedAt = $now;
        }
    }

    /**
     * Returns UUID of the template.
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * Gets title text.
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Sets title text.
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Gets translation key for title.
     */
    public function getTitleKey(): ?string
    {
        return $this->titleKey;
    }

    /**
     * Sets translation key for title.
     */
    public function setTitleKey(?string $titleKey): void
    {
        $this->titleKey = $titleKey;
    }

    /**
     * Gets description text.
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Sets description text.
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * Gets structure (e.g. Markdown or JSON layout).
     */
    public function getStructure(): ?string
    {
        return $this->structure;
    }

    /**
     * Sets structure (e.g. Markdown or JSON layout).
     */
    public function setStructure(?string $structure): void
    {
        $this->structure = $structure;
    }

    /**
     * Gets associated course program.
     */
    public function getCourseProgram(): ?CourseProgram
    {
        return $this->courseProgram;
    }

    /**
     * Sets associated course program.
     */
    public function setCourseProgram(?CourseProgram $courseProgram): void
    {
        $this->courseProgram = $courseProgram;
    }

    /**
     * Checks if template is active.
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * Activates or deactivates the template.
     */
    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    /**
     * Gets language code.
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * Sets language code.
     */
    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }

    /**
     * Checks if template is archived.
     */
    public function isArchived(): bool
    {
        return $this->isArchived;
    }

    /**
     * Archives or unarchives the template.
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
