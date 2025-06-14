<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Equed\EquedLms\Domain\Model\Traits\PersistenceTrait;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * AuditLog
 *
 * Captures sanitized audit entries for user actions.
 */
final class AuditLog extends AbstractEntity
{
    use PersistenceTrait;

    /** Hash of the user identifier */
    protected string $userHash = '';

    /** Action performed */
    protected string $action = '';

    /** Optional details (already sanitized) */
    protected ?string $details = null;

    public function initializeObject(): void
    {
        $this->initializePersistenceTrait();
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
        $this->userHash = sha1((string) $userIdentifier);
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function setAction(string $action): void
    {
        $this->action = $action;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(?string $details): void
    {
        $this->details = $details;
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
