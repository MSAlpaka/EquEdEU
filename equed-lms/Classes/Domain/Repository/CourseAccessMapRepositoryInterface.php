<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\CourseAccessMap;
use Equed\EquedLms\Domain\Model\CourseProgram;
use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

interface CourseAccessMapRepositoryInterface
{
    /**
     * @param FrontendUser $frontendUser
     * @return CourseAccessMap[]
     */
    public function findByUser(FrontendUser $frontendUser): array;

    /**
     * @param CourseProgram $courseProgram
     * @return CourseAccessMap[]
     */
    public function findByCourseProgram(CourseProgram $courseProgram): array;

    /**
     * @return QueryInterface<CourseAccessMap>
     */
    public function createQuery(): QueryInterface;
}

