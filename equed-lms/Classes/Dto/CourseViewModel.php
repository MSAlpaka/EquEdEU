<?php

declare(strict_types=1);

namespace Equed\EquedLms\Dto;

use Equed\EquedLms\Domain\Model\Course;

final class CourseViewModel implements \JsonSerializable
{
    public function __construct(
        private readonly ?Course $course = null,
        private readonly int $progress = 0,
        private readonly ?string $error = null,
    ) {
    }

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function getProgress(): int
    {
        return $this->progress;
    }

    public function getError(): ?string
    {
        return $this->error;
    }

    public function hasError(): bool
    {
        return $this->error !== null;
    }

    public function jsonSerialize(): array
    {
        return [
            'course' => $this->course,
            'progress' => $this->progress,
            'error' => $this->error,
        ];
    }
}
