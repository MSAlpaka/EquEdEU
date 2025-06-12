<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Service;

use Equed\EquedLms\Domain\Model\FrontendUser;

interface DashboardServiceInterface
{
    /**
     * Retrieve all dashboard data for a frontend user.
     *
     * @param FrontendUser $user
     * @return array<string,mixed>
     */
    public function getDashboardDataForUser(FrontendUser $user): array;
}
