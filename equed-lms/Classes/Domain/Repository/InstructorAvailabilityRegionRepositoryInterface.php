<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\CourseInstance;
use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Domain\Model\InstructorAvailabilityRegion;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

interface InstructorAvailabilityRegionRepositoryInterface
{
    /**
     * @param FrontendUser $instructor
     * @return InstructorAvailabilityRegion[]
     */
    public function findByInstructor(FrontendUser $instructor): array;

    /**
     * @param CourseInstance $courseInstance
     * @return InstructorAvailabilityRegion[]
     */
    public function findByCourseInstance(CourseInstance $courseInstance): array;

    /**
     * @return QueryInterface<InstructorAvailabilityRegion>
     */
    public function createQuery(): QueryInterface;
}

