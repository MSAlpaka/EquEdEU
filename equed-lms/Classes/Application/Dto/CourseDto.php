<?php

declare(strict_types=1);

namespace Equed\EquedLms\Application\Dto;

/**
 * Data Transfer Object for course records.
 */
final class CourseDto implements \JsonSerializable
{
    public function __construct(
        private readonly int $id,
        private readonly string $title,
        private readonly ?string $titleKey,
        private readonly ?string $description,
        private readonly ?string $descriptionKey,
        private readonly ?string $startDate,
        private readonly string $location
    ) {
    }

    public function getId(): int
    {
        return $this->id;
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

    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'titleKey' => $this->titleKey,
            'description' => $this->description,
            'descriptionKey' => $this->descriptionKey,
            'startDate' => $this->startDate,
            'location' => $this->location,
        ];
    }
}
