<?php

declare(strict_types=1);

namespace Equed\EquedLms\Application\Dto;

/**
 * Data Transfer Object for course modules.
 */
final class ModuleDto implements \JsonSerializable
{
    public function __construct(
        private readonly int $id,
        private readonly string $uuid,
        private readonly string $title,
        private readonly ?string $titleKey,
        private readonly ?string $description,
        private readonly ?string $descriptionKey,
        private readonly string $identifier,
        private readonly ?int $courseProgramId,
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

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function getCourseProgramId(): ?int
    {
        return $this->courseProgramId;
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
            'identifier' => $this->identifier,
            'courseProgramId' => $this->courseProgramId,
        ];
    }
}
