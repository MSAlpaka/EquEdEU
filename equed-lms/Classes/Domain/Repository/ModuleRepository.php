<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\Module;
use Equed\EquedLms\Domain\Model\CourseProgram;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository for Module entities.
 */
final class ModuleRepository extends Repository
{
    /**
     * Find modules for the given course program.
     *
     * @param CourseProgram $program
     * @return Module[]
     */
    public function findByCourseProgram(CourseProgram $program): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('courseProgram', $program)
        );

        return $query->execute()->toArray();
    }

    /**
     * Find a module by its identifier.
     *
     * @param string $identifier
     * @return Module|null
     */
    public function findByIdentifier(string $identifier): ?Module
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('identifier', $identifier)
        );
        $query->setLimit(1);

        return $query->execute()->getFirst();
    }

    /**
     * Find a module by its UUID.
     *
     * @param string $uuid
     * @return Module|null
     */
    public function findByUuid(string $uuid): ?Module
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('uuid', $uuid)
        );
        $query->setLimit(1);

        return $query->execute()->getFirst();
    }
}
