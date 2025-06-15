<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Service;

use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Dto\DashboardData;

interface DashboardServiceInterface
{
    /**
     * Retrieve all dashboard data for a frontend user.
     *
     * @param FrontendUser $user
     */
    public function getDashboardDataForUser(FrontendUser $user): DashboardData;
}
