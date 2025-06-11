<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\CourseMaterial;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository for CourseMaterial entities.
 */
class CourseMaterialRepository extends Repository
{
    /**
     * Finds a CourseMaterial by its slug (URL key).
     *
     * @param string $slug
     * @return CourseMaterial|null
     */
    public function findBySlug(string $slug): ?CourseMaterial
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('slug', $slug)
        );
        $query->setLimit(1);

        return $query->execute()->getFirst();
    }

    /**
     * Finds all active CourseMaterial entities (hidden = false).
     *
     * @return CourseMaterial[]
     */
    public function findAllActive(): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('hidden', 0)
        );

        return $query->execute()->toArray();
    }
}
// EOF
