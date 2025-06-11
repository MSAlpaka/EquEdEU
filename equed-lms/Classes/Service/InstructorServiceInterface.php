<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

interface InstructorServiceInterface
{
    /**
     * @return array<array-key, mixed>
     */
    public function getAllActive(): array;

    /**
     * @return array<array-key, mixed>|null
     */
    public function getById(int $id): array|null;
}
