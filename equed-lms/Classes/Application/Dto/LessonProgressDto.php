<?php

declare(strict_types=1);

namespace Equed\EquedLms\Application\Dto;

/**
 * DTO representing progress information for a lesson.
 */
final class LessonProgressDto implements \JsonSerializable
{
    public function __construct(
        private readonly string $uuid,
        private readonly ?int $userId,
        private readonly int $lessonId,
        private readonly int $progress,
        private readonly string $status,
        private readonly bool $completed,
        private readonly ?string $completedAt,
        private readonly string $updatedAt,
    ) {
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function getLessonId(): int
    {
        return $this->lessonId;
    }

    public function getProgress(): int
    {
        return $this->progress;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function isCompleted(): bool
    {
        return $this->completed;
    }

    public function getCompletedAt(): ?string
    {
        return $this->completedAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function jsonSerialize(): array
    {
        return [
            'uuid' => $this->uuid,
            'userId' => $this->userId,
            'lessonId' => $this->lessonId,
            'progress' => $this->progress,
            'status' => $this->status,
            'completed' => $this->completed,
            'completedAt' => $this->completedAt,
            'updatedAt' => $this->updatedAt,
        ];
    }
}
