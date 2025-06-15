<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;
use Equed\EquedLms\Enum\LanguageCode;

use DateTimeImmutable;
use Equed\Core\Service\ClockInterface;
use Equed\Core\Service\UuidGeneratorInterface;
use TYPO3\CMS\Extbase\Annotation\Inject;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * SearchLog
 *
 * Stores sanitized search queries performed by users.
 */
final class SearchLog extends AbstractEntity
{
    protected string $uuid;

    #[Inject]
    protected UuidGeneratorInterface $uuidGenerator;

    #[Inject]
    protected ClockInterface $clock;

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
        $this->uuid = \Ramsey\Uuid\Uuid::uuid4()->toString();
        $this->createdAt = $now;
        $this->updatedAt = $now;
    }

    public function initializeObject(): void
    {
        if (empty($this->uuid)) {
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

    public function getUserHash(): string
    {
        return $this->userHash;
    }

    public function setUserIdentifier(string|int $userIdentifier): void
    {
        $this->userHash = hash('sha256', (string) $userIdentifier);
    }

    public function getTermHash(): string
    {
        return $this->termHash;
    }

    public function setSearchTerm(string $term): void
    {
        $this->termHash = hash('sha256', $term);
    }

    public function getLang(): LanguageCode
    {
        return $this->lang;
    }

    public function setLang(LanguageCode $lang): void
    {
        $this->lang = $lang;
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
