<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\InstructorAvailabilityRegion;
use Equed\EquedLms\Domain\Model\CourseInstance;
use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository for InstructorAvailabilityRegion entities.
 */
final class InstructorAvailabilityRegionRepository extends Repository
{
    /**
     * Finds all availability regions for a given instructor.
     *
     * @param FrontendUser $instructor
     * @return InstructorAvailabilityRegion[]
     */
    public function findByInstructor(FrontendUser $instructor): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('instructor', $instructor)
        );

        return $query->execute()->toArray();
    }

    /**
     * Finds all availability regions for a specific course instance.
     *
     * @param CourseInstance $courseInstance
     * @return InstructorAvailabilityRegion[]
     */
    public function findByCourseInstance(CourseInstance $courseInstance): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('courseInstance', $courseInstance)
        );

        return $query->execute()->toArray();
    }
}
// EOF
