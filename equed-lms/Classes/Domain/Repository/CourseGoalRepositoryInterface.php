<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\CourseGoal;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

interface CourseGoalRepositoryInterface
{
    /**
     * @return CourseGoal[]|QueryResultInterface
     */
    public function findAll();

    /**
     * @param int $courseProgramId
     * @return CourseGoal[]
     */
    public function findByCourseProgram(int $courseProgramId): array;
}
