<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

interface QuizServiceInterface
{
    /**
     * @return array<array-key, mixed>
     */
    public function getAvailable(): array;

    /**
     * @return array<array-key, mixed>|null
     */
    public function getById(int $id): array|null;
}
