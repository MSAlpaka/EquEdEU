<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

interface SubmissionServiceInterface
{
    /**
     * @return array<array-key, mixed>
     */
    public function getAllForUser(): array;

    /**
     * @return array<array-key, mixed>|null
     */
    public function getById(int $id): array|null;
}
