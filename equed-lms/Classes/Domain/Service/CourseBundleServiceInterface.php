<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Service;

use Equed\EquedLms\Domain\Model\CourseBundle;

/**
 * Provides course bundle information for frontend users.
 */
interface CourseBundleServiceInterface
{
    /**
     * Returns bundles available to the specified user.
     *
     * @param int $userId Frontend user UID
     * @return CourseBundle[]
     */
    public function getAvailableBundles(int $userId): array;
}

