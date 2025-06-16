<?php

declare(strict_types=1);

namespace Equed\EquedLms\Application\Dto;

/**
 * Data Transfer Object for course programs.
 */
final class CourseProgramDto implements \JsonSerializable
{
    public function __construct(
        private readonly int $id,
        private readonly string $uuid,
        private readonly string $title,
        private readonly ?string $titleKey,
        private readonly ?string $description,
        private readonly ?string $descriptionKey,
        private readonly string $category,
        private readonly string $availableFrom,
        private readonly bool $visible,
        private readonly bool $archived,
        private readonly ?string $badgeIconUrl,
        private readonly bool $requiresExternalExaminer,
        private readonly bool $certifierMustValidate,
        private readonly bool $recertificationRequired,
        private readonly int $recertificationIntervalYears,
        private readonly bool $visibleInCatalog,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getTitleKey(): ?string
    {
        return $this->titleKey;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getDescriptionKey(): ?string
    {
        return $this->descriptionKey;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getAvailableFrom(): string
    {
        return $this->availableFrom;
    }

    public function isVisible(): bool
    {
        return $this->visible;
    }

    public function isArchived(): bool
    {
        return $this->archived;
    }

    public function getBadgeIconUrl(): ?string
    {
        return $this->badgeIconUrl;
    }

    public function requiresExternalExaminer(): bool
    {
        return $this->requiresExternalExaminer;
    }

    public function certifierMustValidate(): bool
    {
        return $this->certifierMustValidate;
    }

    public function isRecertificationRequired(): bool
    {
        return $this->recertificationRequired;
    }

    public function getRecertificationIntervalYears(): int
    {
        return $this->recertificationIntervalYears;
    }

    public function isVisibleInCatalog(): bool
    {
        return $this->visibleInCatalog;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'title' => $this->title,
            'titleKey' => $this->titleKey,
            'description' => $this->description,
            'descriptionKey' => $this->descriptionKey,
            'category' => $this->category,
            'availableFrom' => $this->availableFrom,
            'visible' => $this->visible,
            'archived' => $this->archived,
            'badgeIconUrl' => $this->badgeIconUrl,
            'requiresExternalExaminer' => $this->requiresExternalExaminer,
            'certifierMustValidate' => $this->certifierMustValidate,
            'recertificationRequired' => $this->recertificationRequired,
            'recertificationIntervalYears' => $this->recertificationIntervalYears,
            'visibleInCatalog' => $this->visibleInCatalog,
        ];
    }
}
