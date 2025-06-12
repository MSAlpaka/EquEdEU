<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\CourseProgram;
use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Domain\Model\InstructorEligibility;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository for InstructorEligibility entities.
 */
final class InstructorEligibilityRepository extends Repository
{
    /**
     * Finds all eligibility entries for a given instructor.
     *
     * @param FrontendUser $instructor
     * @return InstructorEligibility[]
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
     * Finds all instructors eligible for a given course program.
     *
     * @param CourseProgram $courseProgram
     * @return InstructorEligibility[]
     */
    public function findByCourseProgram(CourseProgram $courseProgram): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('courseProgram', $courseProgram)
        );

        return $query->execute()->toArray();
    }

    /**
     * Checks if a given instructor is eligible for a specific course program.
     *
     * @param FrontendUser  $instructor
     * @param CourseProgram $courseProgram
     * @return bool
     */
    public function isEligible(FrontendUser $instructor, CourseProgram $courseProgram): bool
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd([
                $query->equals('instructor', $instructor),
                $query->equals('courseProgram', $courseProgram),
            ])
        );

        return $query->execute()->count() > 0;
    }
}
// EOF
