<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\CourseProgram;
use Equed\EquedLms\Domain\Model\Module;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

interface ModuleRepositoryInterface
{
    /**
     * @param CourseProgram $program
     * @return Module[]
     */
    public function findByCourseProgram(CourseProgram $program): array;

    /**
     * @param string $identifier
     * @return Module|null
     */
    public function findByIdentifier(string $identifier): ?Module;

    /**
     * @param string $uuid
     * @return Module|null
     */
    public function findByUuid(string $uuid): ?Module;

    /**
     * @param CourseProgram $program
     * @return Module[]
     */
    public function findActiveModules(CourseProgram $program): array;

    /**
     * @param int $programId
     * @return int
     */
    public function countByCourseProgram(int $programId): int;

    /**
     * @return QueryInterface<Module>
     */
    public function createQuery(): QueryInterface;
}

