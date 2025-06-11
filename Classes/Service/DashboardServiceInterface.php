<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

interface DashboardServiceInterface
{
    /**
     * @return array<array-key, mixed>
     */
    public function getDashboardDataForUser(object $user): array;
}
