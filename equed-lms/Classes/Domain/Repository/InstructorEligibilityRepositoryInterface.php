<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\CourseProgram;
use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Domain\Model\InstructorEligibility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

interface InstructorEligibilityRepositoryInterface
{
    /**
     * @param FrontendUser $instructor
     * @return InstructorEligibility[]
     */
    public function findByInstructor(FrontendUser $instructor): array;

    /**
     * @param CourseProgram $courseProgram
     * @return InstructorEligibility[]
     */
    public function findByCourseProgram(CourseProgram $courseProgram): array;

    /**
     * @param FrontendUser  $instructor
     * @param CourseProgram $courseProgram
     * @return bool
     */
    public function isEligible(FrontendUser $instructor, CourseProgram $courseProgram): bool;

    /**
     * @return QueryInterface<InstructorEligibility>
     */
    public function createQuery(): QueryInterface;
}

