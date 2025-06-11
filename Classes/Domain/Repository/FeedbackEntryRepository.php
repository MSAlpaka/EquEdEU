<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\CourseInstance;
use Equed\EquedLms\Domain\Model\FeedbackEntry;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository for FeedbackEntry entities.
 */
class FeedbackEntryRepository extends Repository
{
    /**
     * Finds all feedback entries for a given course instance.
     *
     * @param CourseInstance $courseInstance
     * @return FeedbackEntry[]
     */
    public function findByCourseInstance(CourseInstance $courseInstance): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('courseInstance', $courseInstance)
        );

        return $query->execute()->toArray();
    }

    /**
     * Finds all feedback entries visible to instructors for a given course instance.
     *
     * @param CourseInstance $courseInstance
     * @return FeedbackEntry[]
     */
    public function findVisibleToInstructor(CourseInstance $courseInstance): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd([
                $query->equals('courseInstance', $courseInstance),
                $query->equals('instructorFeedback', true),
            ])
        );

        return $query->execute()->toArray();
    }
}
// EOF
