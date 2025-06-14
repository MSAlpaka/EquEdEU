<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use Equed\EquedLms\Enum\LanguageCode;

/**
 * GlossaryEntry
 *
 * Represents a single term and its definition for the course glossary.
 */
final class GlossaryEntry extends AbstractEntity
{
    /** Unique identifier */
    protected string $uuid;

    /** Term text */
    protected string $term = '';

    /** Optional translation key for the term */
    protected ?string $termKey = null; // for hybrid translation label

    /** Definition text */
    protected string $definition = '';

    /** Optional translation key for the definition */
    protected ?string $definitionKey = null; // for hybrid translation label

    /** Related course program */
    #[ManyToOne]
    #[Lazy]
    protected ?CourseProgram $courseProgram = null;

    /** Language of the entry */
    protected LanguageCode $language = LanguageCode::EN;

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

    public function getTerm(): string
    {
        return $this->term;
    }

    public function setTerm(string $term): void
    {
        $this->term = $term;
    }

    public function getTermKey(): ?string
    {
        return $this->termKey;
    }

    public function setTermKey(?string $termKey): void
    {
        $this->termKey = $termKey;
    }

    public function getDefinition(): string
    {
        return $this->definition;
    }

    public function setDefinition(string $definition): void
    {
        $this->definition = $definition;
    }

    public function getDefinitionKey(): ?string
    {
        return $this->definitionKey;
    }

    public function setDefinitionKey(?string $definitionKey): void
    {
        $this->definitionKey = $definitionKey;
    }

    public function getCourseProgram(): ?CourseProgram
    {
        return $this->courseProgram;
    }

    public function setCourseProgram(?CourseProgram $courseProgram): void
    {
        $this->courseProgram = $courseProgram;
    }

    public function getLanguage(): LanguageCode
    {
        return $this->language;
    }

    public function setLanguage(LanguageCode $language): void
    {
        $this->language = $language;
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
