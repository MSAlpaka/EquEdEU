<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\CourseFeedback;
use Equed\EquedLms\Domain\Model\CourseInstance;
use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository for CourseFeedback entities.
 */
class FeedbackRepository extends Repository
{
    /**
     * Finds all feedback entries for a specific frontend user.
     *
     * @param FrontendUser $user
     * @return CourseFeedback[]
     */
    public function findByFeUser(FrontendUser $user): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('submittedByUser', $user)
        );

        return $query->execute()->toArray();
    }

    /**
     * Finds all feedback entries not yet seen by instructors.
     *
     * @return CourseFeedback[]
    */
    public function findUnseenFeedback(): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('isVisibleToInstructor', false)
        );

        return $query->execute()->toArray();
    }

    /**
     * Finds all feedback entries that have not been analyzed by GPT.
     *
     * @return QueryResultInterface<CourseFeedback>
     */
    public function findUnanalyzed(): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('status', 'submitted')
        );

        return $query->execute();
    }

    /**
     * Finds a single feedback entry for a given user and course instance.
     *
     * @param FrontendUser   $user
     * @param CourseInstance $courseInstance
     * @return CourseFeedback|null
     */
    public function findByUserAndCourse(FrontendUser $user, CourseInstance $courseInstance): ?CourseFeedback
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd([
                $query->equals('submittedByUser', $user),
                $query->equals('userCourseRecord.courseInstance', $courseInstance),
            ])
        );
        $query->setLimit(1);

        return $query->execute()->getFirst();
    }
}
// EOF
