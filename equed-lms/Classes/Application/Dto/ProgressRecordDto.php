<?php

declare(strict_types=1);

namespace Equed\EquedLms\Application\Dto;

/**
 * DTO representing a user progress record.
 */
final class ProgressRecordDto implements \JsonSerializable
{
    public function __construct(
        private readonly string $uuid,
        private readonly ?int $userId,
        private readonly ?int $lessonId,
        private readonly string $status,
        private readonly int $progressPercent,
        private readonly ?string $lastAccessedAt,
        private readonly bool $completed,
        private readonly ?string $completedAt,
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

    public function getLessonId(): ?int
    {
        return $this->lessonId;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getProgressPercent(): int
    {
        return $this->progressPercent;
    }

    public function getLastAccessedAt(): ?string
    {
        return $this->lastAccessedAt;
    }

    public function isCompleted(): bool
    {
        return $this->completed;
    }

    public function getCompletedAt(): ?string
    {
        return $this->completedAt;
    }

    public function jsonSerialize(): array
    {
        return [
            'uuid' => $this->uuid,
            'userId' => $this->userId,
            'lessonId' => $this->lessonId,
            'status' => $this->status,
            'progressPercent' => $this->progressPercent,
            'lastAccessedAt' => $this->lastAccessedAt,
            'completed' => $this->completed,
            'completedAt' => $this->completedAt,
        ];
    }
}
