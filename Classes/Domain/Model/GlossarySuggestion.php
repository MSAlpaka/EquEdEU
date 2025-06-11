<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use TYPO3\CMS\Extbase\Annotation\ORM\ManyToOne;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * GlossarySuggestion
 *
 * Represents a user-submitted suggestion for a glossary entry, pending review.
 */
final class GlossarySuggestion extends AbstractEntity
{
    /**
     * Unique identifier for the suggestion
     *
     * @var string
     */
    protected string $uuid;

    /**
     * Suggested term
     *
     * @var string
     */
    protected string $term = '';

    /**
     * Translation key for term label
     *
     * @var string|null
     */
    protected ?string $termKey = null;

    /**
     * Definition text
     *
     * @var string
     */
    protected string $definition = '';

    /**
     * Translation key for definition
     *
     * @var string|null
     */
    protected ?string $definitionKey = null;

    #[ManyToOne]
    #[Lazy]
    /** @var FrontendUser|null */
    protected ?FrontendUser $submittedBy = null;

    /**
     * Language identifier
     *
     * @var string
     */
    protected string $language = 'en';

    /**
     * Current review status (pending | approved | rejected)
     *
     * @var string
     */
    protected string $status = 'pending'; // pending | approved | rejected

    /**
     * Optional admin review comment
     *
     * @var string|null
     */
    protected ?string $reviewComment = null;

    /**
     * Flag if the suggestion was archived
     *
     * @var bool
     */
    protected bool $isArchived = false;

    /**
     * Creation timestamp
     *
     * @var DateTimeImmutable
     */
    protected DateTimeImmutable $createdAt;

    /**
     * Last update timestamp
     *
     * @var DateTimeImmutable
     */
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

    public function getSubmittedBy(): ?FrontendUser
    {
        return $this->submittedBy;
    }

    public function setSubmittedBy(?FrontendUser $submittedBy): void
    {
        $this->submittedBy = $submittedBy;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getReviewComment(): ?string
    {
        return $this->reviewComment;
    }

    public function setReviewComment(?string $reviewComment): void
    {
        $this->reviewComment = $reviewComment;
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
