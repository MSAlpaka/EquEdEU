<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;
use Equed\EquedLms\Enum\LanguageCode;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * ExternalSystemSync
 *
 * @package Equed\EquedLms\Domain\Model
 */
final class ExternalSystemSync extends AbstractEntity
{
    /**
     * @var string
     */
    protected string $uuid;

    /**
     * Target external system identifier (e.g. eqf, zfu, shop, api)
     *
     * @var string
     */
    protected string $targetSystem = '';

    /**
     * Action to perform (push | pull | notify | validate)
     *
     * @var string
     */
    protected string $action = '';

    /**
     * Current status (pending | success | failed)
     *
     * @var string
     */
    protected string $status = 'pending';

    /**
     * Optional JSON payload
     *
     * @var string|null
     */
    protected ?string $payload = null;

    /**
     * Reference ID in external system
     *
     * @var string|null
     */
    protected ?string $referenceId = null;

    /**
     * Error message on failure
     *
     * @var string|null
     */
    protected ?string $errorMessage = null;

    /**
     * Language code
     *
     * @var string
     */
    protected LanguageCode $lang = LanguageCode::EN;

    /**
     * Soft-delete flag
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

    public function getTargetSystem(): string
    {
        return $this->targetSystem;
    }

    public function setTargetSystem(string $targetSystem): void
    {
        $this->targetSystem = $targetSystem;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function setAction(string $action): void
    {
        $this->action = $action;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getPayload(): ?string
    {
        return $this->payload;
    }

    public function setPayload(?string $payload): void
    {
        $this->payload = $payload;
    }

    public function getReferenceId(): ?string
    {
        return $this->referenceId;
    }

    public function setReferenceId(?string $referenceId): void
    {
        $this->referenceId = $referenceId;
    }

    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    public function setErrorMessage(?string $errorMessage): void
    {
        $this->errorMessage = $errorMessage;
    }

    public function getLang(): LanguageCode
    {
        return $this->lang;
    }

    public function setLang(LanguageCode $lang): void
    {
        $this->lang = $lang;
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
