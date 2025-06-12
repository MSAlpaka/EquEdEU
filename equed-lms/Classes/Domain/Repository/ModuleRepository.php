<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\Module;
use Equed\EquedLms\Domain\Model\CourseProgram;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository for Module entities.
 *
 * @extends Repository<Module>
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

    /**
     * Find active modules for a course program.
     *
     * A module is considered active when its parent program is visible, not
     * archived and available.
     *
     * @param CourseProgram $program Related course program
     * @return Module[]               List of matching modules
     */
    public function findActiveModules(CourseProgram $program): array
    {
        $now = new \DateTimeImmutable();

        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd([
                $query->equals('courseProgram', $program),
                $query->equals('courseProgram.isVisible', true),
                $query->equals('courseProgram.isArchived', false),
                $query->lessThanOrEqual('courseProgram.availableFrom', $now),
            ])
        );

        return $query->execute()->toArray();
    }

    /**
     * Count modules for a specific program.
     *
     * @param int $programId UID of the course program
     * @return int           Number of modules
     */
    public function countByCourseProgram(int $programId): int
    {
        $qb = $this->createQuery()->getQueryBuilder();
        $qb
            ->select($qb->expr()->count('*'))
            ->from('tx_equedlms_domain_model_module')
            ->where(
                $qb->expr()->eq('course_program', $qb->createNamedParameter($programId, \PDO::PARAM_INT))
            );

        $result = $qb->executeQuery()->fetchOne();

        return $result === false ? 0 : (int) $result;
    }
}
