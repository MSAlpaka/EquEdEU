<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

interface QmsCaseServiceInterface
{
    /**
     * @return array<array-key, mixed>
     */
    public function getAllCases(): array;

    /**
     * @return array<array-key, mixed>|null
     */
    public function getCaseById(int $id): array|null;
}
