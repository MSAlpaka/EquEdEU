<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\CourseBundle;
use TYPO3\CMS\Extbase\Persistence\Repository;
use Equed\EquedLms\Domain\Repository\CourseBundleRepositoryInterface;

/**
 * Repository for CourseBundle entities.

 *
 * @extends Repository<CourseBundle>
 */
final class CourseBundleRepository extends Repository implements CourseBundleRepositoryInterface
{
    /**
     * Finds a CourseBundle by its slug.
     *
     * @param string $slug
     * @return CourseBundle|null
     */
    public function findBySlug(string $slug): ?CourseBundle
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('slug', $slug)
        );
        $query->setLimit(1);

        return $query->execute()->getFirst();
    }

    /**
     * Finds all active CourseBundle entities (hidden = false).
     *
     * @return CourseBundle[]
     */
    public function findAllActive(): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('hidden', false)
        );

        return $query->execute()->toArray();
    }
}
