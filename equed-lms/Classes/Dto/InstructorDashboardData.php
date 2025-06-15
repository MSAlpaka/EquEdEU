<?php

declare(strict_types=1);

namespace Equed\EquedLms\Dto;

/**
 * Data Transfer Object for instructor dashboard metrics.
 */
final class InstructorDashboardData implements \JsonSerializable
{
    public function __construct(
        private readonly int $courseInstanceCount,
        private readonly int $participantCount,
        private readonly int $validatedRecords,
        private readonly int $openTasks,
    ) {
    }

    public function getCourseInstanceCount(): int
    {
        return $this->courseInstanceCount;
    }

    public function getParticipantCount(): int
    {
        return $this->participantCount;
    }

    public function getValidatedRecords(): int
    {
        return $this->validatedRecords;
    }

    public function getOpenTasks(): int
    {
        return $this->openTasks;
    }

    public function jsonSerialize(): array
    {
        return [
            'courseInstanceCount' => $this->courseInstanceCount,
            'participantCount'    => $this->participantCount,
            'validatedRecords'    => $this->validatedRecords,
            'openTasks'           => $this->openTasks,
        ];
    }
}
