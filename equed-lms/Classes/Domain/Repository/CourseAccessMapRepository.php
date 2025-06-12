<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\CourseAccessMap;
use Equed\EquedLms\Domain\Model\CourseProgram;
use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository for CourseAccessMap entities.

 *
 * @extends Repository<CourseAccessMap>
 */
final class CourseAccessMapRepository extends Repository
{
    /**
     * Finds all access maps for a specific instructor.
     *
     * @param FrontendUser $frontendUser
     * @return CourseAccessMap[]
     */
    public function findByUser(FrontendUser $frontendUser): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('instructor', $frontendUser)
        );

        return $query->execute()->toArray();
    }

    /**
     * Finds all access maps for a specific course program.
     *
     * @param CourseProgram $courseProgram
     * @return CourseAccessMap[]
     */
    public function findByCourseProgram(CourseProgram $courseProgram): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('courseProgram', $courseProgram)
        );

        return $query->execute()->toArray();
    }
}
