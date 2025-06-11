<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;
use Equed\EquedLms\Domain\Model\CourseGoal;

/**
 * Repository for CourseGoal entities.
 *
 * @extends Repository<CourseGoal>
 */
class CourseGoalRepository extends Repository
{
    /**
     * Find goals for a specific course program.
     *
     * @param int $courseProgramId
     * @return CourseGoal[]
     */
    public function findByCourseProgram(int $courseProgramId): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('courseProgram', $courseProgramId)
        );

        return $query->execute()->toArray();
    }
}
