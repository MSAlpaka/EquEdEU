<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use Equed\EquedLms\Enum\LanguageCode;

/**
 * SearchLog
 *
 * Stores sanitized search queries performed by users.
 */
final class SearchLog extends AbstractEntity
{
    protected string $uuid;

    /** Hash of the user identifier */
    protected string $userHash = '';

    /** Hash of the searched term */
    protected string $termHash = '';

    /** Language used for the search */
    protected LanguageCode $lang = LanguageCode::EN;

    protected DateTimeImmutable $createdAt;
    protected DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $now = new DateTimeImmutable();
        $this->uuid = Uuid::uuid4()->toString();
        $this->createdAt = $now;
        $this->updatedAt = $now;
    }

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
    }

    /**
     * Get the UUID.
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * Hash of the user identifier.
     */
    public function getUserHash(): string
    {
        return $this->userHash;
    }

    /**
     * Set the user identifier.
     */
    public function setUserIdentifier(string|int $userIdentifier): void
    {
        $this->userHash = hash('sha256', (string) $userIdentifier);
    }

    /**
     * Hash of the searched term.
     */
    public function getTermHash(): string
    {
        return $this->termHash;
    }

    /**
     * Set the search term.
     */
    public function setSearchTerm(string $term): void
    {
        $this->termHash = hash('sha256', $term);
    }

    /**
     * Language used for the search.
     */
    public function getLang(): LanguageCode
    {
        return $this->lang;
    }

    /**
     * Set language used for the search.
     */
    public function setLang(LanguageCode $lang): void
    {
        $this->lang = $lang;
    }

    /**
     * Get the creation timestamp.
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Set the creation timestamp.
     */
    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get the last update timestamp.
     */
    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * Set the last update timestamp.
     */
    public function setUpdatedAt(DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
