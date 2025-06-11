<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * SystemSettings
 *
 * Stores key-value configuration pairs for the LMS.
 */
final class SystemSettings extends AbstractEntity
{
    /** Unique identifier */
    protected string $uuid;

    /** Configuration key */
    protected string $settingKey = '';

    /** Setting value */
    protected string $value = '';

    /** Data type hint */
    protected int $dataType = 0;

    /** Optional description */
    protected ?string $description = null;

    /** Flag whether value can be edited */
    protected bool $isEditable = false;

    /** Flag whether admins can see this setting */
    protected bool $isVisibleToAdmins = false;

    /** Optional grouping label */
    protected ?string $group = null;

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

    public function getSettingKey(): string
    {
        return $this->settingKey;
    }

    public function setSettingKey(string $settingKey): void
    {
        $this->settingKey = $settingKey;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    public function getDataType(): int
    {
        return $this->dataType;
    }

    public function setDataType(int $dataType): void
    {
        $this->dataType = $dataType;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function isEditable(): bool
    {
        return $this->isEditable;
    }

    public function setIsEditable(bool $isEditable): void
    {
        $this->isEditable = $isEditable;
    }

    public function isVisibleToAdmins(): bool
    {
        return $this->isVisibleToAdmins;
    }

    public function setIsVisibleToAdmins(bool $isVisibleToAdmins): void
    {
        $this->isVisibleToAdmins = $isVisibleToAdmins;
    }

    public function getGroup(): ?string
    {
        return $this->group;
    }

    public function setGroup(?string $group): void
    {
        $this->group = $group;
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
