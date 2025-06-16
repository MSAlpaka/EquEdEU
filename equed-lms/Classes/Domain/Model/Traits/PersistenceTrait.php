<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model\Traits;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;

/**
 * Provides basic persistence fields and helpers for domain models.
 */
trait PersistenceTrait
{
    /** Unique identifier */
    protected string $uuid = '';

    /** Object creation timestamp */
    protected DateTimeImmutable $createdAt;

    /** Last update timestamp */
    protected DateTimeImmutable $updatedAt;

    /**
     * Initializes UUID and timestamps on demand.
     */
    protected function initializePersistenceTrait(): void
    {
        if ($this->uuid === '') {
            $this->uuid = Uuid::uuid4()->toString();
        }

        $now = new DateTimeImmutable();

        if (!isset($this->createdAt)) {
            $this->createdAt = $now;
        }

        if (!isset($this->updatedAt)) {
            $this->updatedAt = $now;
        }
    }

    /**
     * Returns the record UUID.
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * Gets the creation date.
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Sets the creation date.
     */
    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Gets the last update date.
     */
    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * Sets the last update date.
     */
    public function setUpdatedAt(DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
