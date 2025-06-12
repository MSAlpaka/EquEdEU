<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\CourseMaterial;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository for CourseMaterial entities.

 *
 * @extends Repository<CourseMaterial>
 */
final class CourseMaterialRepository extends Repository
{
    /**
     * Find a CourseMaterial by its UUID.
     *
     * @param string $uuid
     * @return CourseMaterial|null
     */
    public function findByUuid(string $uuid): ?CourseMaterial
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('uuid', $uuid)
        );
        $query->setLimit(1);

        return $query->execute()->getFirst();
    }

    /**
     * Find all CourseMaterial records that are not deleted.
     *
     * @return CourseMaterial[]
     */
    public function findAllActive(): array
    {
        return $this->createQuery()
            ->execute()
            ->toArray();
    }
}
