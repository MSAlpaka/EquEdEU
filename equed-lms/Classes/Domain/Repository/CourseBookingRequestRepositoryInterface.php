<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\CourseBookingRequest;
use Equed\EquedLms\Domain\Model\CourseProgram;
use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

interface CourseBookingRequestRepositoryInterface
{
    /**
     * @param FrontendUser $frontendUser
     * @return CourseBookingRequest[]
     */
    public function findByFeUser(FrontendUser $frontendUser): array;

    /**
     * @param CourseProgram $courseProgram
     * @return CourseBookingRequest[]
     */
    public function findByCourseProgram(CourseProgram $courseProgram): array;

    /**
     * @return QueryInterface<CourseBookingRequest>
     */
    public function createQuery(): QueryInterface;
}

