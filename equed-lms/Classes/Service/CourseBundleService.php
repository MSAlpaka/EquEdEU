<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\CourseBundle;
use Equed\EquedLms\Domain\Repository\CourseBundleRepositoryInterface;
use Equed\EquedLms\Domain\Service\CourseBundleServiceInterface;

/**
 * Retrieves course bundles for users.
 */
final class CourseBundleService implements CourseBundleServiceInterface
{
    public function __construct(
        private readonly CourseBundleRepositoryInterface $bundleRepository,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getAvailableBundles(int $userId): array
    {
        // For now, simply return all active bundles.
        // Additional filtering logic can be implemented later.
        return $this->bundleRepository->findAllActive();
    }
}

