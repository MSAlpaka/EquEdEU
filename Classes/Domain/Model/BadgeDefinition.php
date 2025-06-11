<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use DateTimeImmutable;
use Equed\EquedLms\Enum\BadgeLevel;
use Ramsey\Uuid\Uuid;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Annotation\Inject;
use Equed\Core\Service\ClockInterface;
use Equed\Core\Service\UuidGeneratorInterface;

/**
 * BadgeDefinition
 *
 * Defines metadata for badge types available in the system.
 */
final class BadgeDefinition extends AbstractEntity
{
    /**
     * Unique identifier
     *
     * @var string
     */
    protected string $uuid;

    #[Inject]
    protected UuidGeneratorInterface $uuidGenerator;

    #[Inject]
    protected ClockInterface $clock;

    /**
     * Badge level
     */
    protected BadgeLevel $level;

    /**
     * Code for this badge
     */
    protected string $code;

    /**
     * Translation key for label
     */
    protected string $labelKey;

    /**
     * Optional translation key for description
     */
    protected ?string $descriptionKey = null;

    /**
     * JSON encoded criteria
     *
     * @var array
     */
    protected array $criteria = [];

    /**
     * Default language of label/description
     *
     * @var string
     */
    protected string $defaultLang = 'en';

    /**
     * Creation timestamp
     */
    protected DateTimeImmutable $createdAt;

    /**
     * Last update timestamp
     */
    protected DateTimeImmutable $updatedAt;

    public function __construct(
        string $code,
        BadgeLevel $level,
        string $labelKey,
        ?string $descriptionKey,
        array $criteria,
        string $defaultLang = 'en'
    ) {
        $now = new DateTimeImmutable();
        $this->uuid           = Uuid::uuid4()->toString();
        $this->createdAt      = $now;
        $this->updatedAt      = $now;
        $this->code           = $code;
        $this->level          = $level;
        $this->labelKey       = $labelKey;
        $this->descriptionKey = $descriptionKey;
        $this->criteria       = $criteria;
        $this->defaultLang    = $defaultLang;
    }

    public function initializeObject(): void
    {
        if ($this->uuid === '') {
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

    public function getCode(): string
    {
        return $this->code;
    }

    public function getLevel(): BadgeLevel
    {
        return $this->level;
    }

    public function getLabelKey(): string
    {
        return $this->labelKey;
    }

    public function getDescriptionKey(): ?string
    {
        return $this->descriptionKey;
    }

    public function getCriteria(): array
    {
        return $this->criteria;
    }

    public function getDefaultLang(): string
    {
        return $this->defaultLang;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
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
