<?php

declare(strict_types=1);

namespace Equed\EquedLms\Dto;

/**
 * Data Transfer Object representing calculated user progress.
 */
final class UserProgress
{
    public function __construct(
        private readonly int $percent,
        private readonly int $completed,
        private readonly int $total
    ) {
    }

    public function getPercent(): int
    {
        return $this->percent;
    }

    public function getCompleted(): int
    {
        return $this->completed;
    }

    public function getTotal(): int
    {
        return $this->total;
    }
}
