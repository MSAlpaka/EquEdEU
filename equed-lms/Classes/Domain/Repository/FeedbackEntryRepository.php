<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\CourseFeedback;
use Equed\EquedLms\Domain\Model\FeedbackEntry;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository for FeedbackEntry entities.

 *
 * @extends Repository<FeedbackEntry>
 */
final class FeedbackEntryRepository extends Repository
{
    /**
     * Finds all feedback entries belonging to a course feedback.
     *
     * @param CourseFeedback $courseFeedback
     * @return FeedbackEntry[]
     */
    public function findByCourseFeedback(CourseFeedback $courseFeedback): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('courseFeedback', $courseFeedback)
        );

        return $query->execute()->toArray();
    }

    /**
     * Finds all feedback entries visible to instructors for a given course feedback.
     *
     * @param CourseFeedback $courseFeedback
     * @return FeedbackEntry[]
     */
    public function findVisibleToInstructor(CourseFeedback $courseFeedback): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd([
                $query->equals('courseFeedback', $courseFeedback),
                $query->equals('courseFeedback.isVisibleToInstructor', true),
            ])
        );

        return $query->execute()->toArray();
    }
}
