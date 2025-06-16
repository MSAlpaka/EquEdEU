<?php

declare(strict_types=1);

namespace Equed\EquedLms\Application\Dto;

/**
 * DTO representing a course instance.
 */
final class CourseInstanceDto implements \JsonSerializable
{
    public function __construct(
        private readonly int $id,
        private readonly string $uuid,
        private readonly string $title,
        private readonly ?string $startDate,
        private readonly ?string $endDate,
        private readonly string $location,
        private readonly string $language,
        private readonly int $seatsTotal,
        private readonly int $seatsAvailable,
        private readonly bool $requiresExternalExaminer,
        private readonly bool $confirmed,
        private readonly bool $visible,
        private readonly bool $archived,
        private readonly string $validationMode,
        private readonly ?int $courseProgramId,
        private readonly ?int $instructorId,
        private readonly ?int $externalExaminerId,
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

    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function getSeatsTotal(): int
    {
        return $this->seatsTotal;
    }

    public function getSeatsAvailable(): int
    {
        return $this->seatsAvailable;
    }

    public function requiresExternalExaminer(): bool
    {
        return $this->requiresExternalExaminer;
    }

    public function isConfirmed(): bool
    {
        return $this->confirmed;
    }

    public function isVisible(): bool
    {
        return $this->visible;
    }

    public function isArchived(): bool
    {
        return $this->archived;
    }

    public function getValidationMode(): string
    {
        return $this->validationMode;
    }

    public function getCourseProgramId(): ?int
    {
        return $this->courseProgramId;
    }

    public function getInstructorId(): ?int
    {
        return $this->instructorId;
    }

    public function getExternalExaminerId(): ?int
    {
        return $this->externalExaminerId;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'title' => $this->title,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'location' => $this->location,
            'language' => $this->language,
            'seatsTotal' => $this->seatsTotal,
            'seatsAvailable' => $this->seatsAvailable,
            'requiresExternalExaminer' => $this->requiresExternalExaminer,
            'confirmed' => $this->confirmed,
            'visible' => $this->visible,
            'archived' => $this->archived,
            'validationMode' => $this->validationMode,
            'courseProgramId' => $this->courseProgramId,
            'instructorId' => $this->instructorId,
            'externalExaminerId' => $this->externalExaminerId,
        ];
    }
}
