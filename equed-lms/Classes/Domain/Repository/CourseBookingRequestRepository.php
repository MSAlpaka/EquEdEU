<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\CourseBookingRequest;
use Equed\EquedLms\Domain\Model\CourseInstance;
use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository for CourseBookingRequest entities.
 */
class CourseBookingRequestRepository extends Repository
{
    /**
     * Finds all booking requests for the given frontend user.
     *
     * @param FrontendUser $frontendUser
     * @return CourseBookingRequest[]
     */
    public function findByFeUser(FrontendUser $frontendUser): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('feUser', $frontendUser)
        );

        return $query->execute()->toArray();
    }

    /**
     * Finds all booking requests for the given course instance.
     *
     * @param CourseInstance $courseInstance
     * @return CourseBookingRequest[]
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
