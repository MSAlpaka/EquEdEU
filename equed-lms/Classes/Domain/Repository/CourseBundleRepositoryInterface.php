<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\CourseBundle;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

interface CourseBundleRepositoryInterface
{
    /**
     * @param string $slug
     * @return CourseBundle|null
     */
    public function findBySlug(string $slug): ?CourseBundle;

    /**
     * @return CourseBundle[]
     */
    public function findAllActive(): array;

    /**
     * @return QueryInterface<CourseBundle>
     */
    public function createQuery(): QueryInterface;
}

