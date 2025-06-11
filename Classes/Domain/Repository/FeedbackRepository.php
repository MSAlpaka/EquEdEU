<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\Feedback;
use Equed\EquedLms\Domain\Model\CourseInstance;
use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository for Feedback entities.
 */
class FeedbackRepository extends Repository
{
    /**
     * Finds all feedback entries for a specific frontend user.
     *
     * @param FrontendUser $user
     * @return Feedback[]
     */
    public function findByFeUser(FrontendUser $user): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('feUser', $user)
        );

        return $query->execute()->toArray();
    }

    /**
     * Finds all feedback entries not yet seen by instructors.
     *
     * @return Feedback[]
     */
    public function findUnseenFeedback(): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('seenByInstructor', false)
        );

        return $query->execute()->toArray();
    }

    /**
     * Finds all feedback entries that have not been analyzed by GPT.
     *
     * @return QueryResultInterface<Feedback>
     */
    public function findUnanalyzed(): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalOr([
                $query->equals('analysisSummary', null),
                $query->equals('analysisSummary', ''),
                $query->equals('suggestedRating', 0),
            ])
        );

        return $query->execute();
    }

    /**
     * Finds a single feedback entry for a given user and course instance.
     *
     * @param FrontendUser   $user
     * @param CourseInstance $courseInstance
     * @return Feedback|null
     */
    public function findByUserAndCourse(FrontendUser $user, CourseInstance $courseInstance): ?Feedback
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd([
                $query->equals('feUser', $user),
                $query->equals('course', $courseInstance),
            ])
        );
        $query->setLimit(1);

        return $query->execute()->getFirst();
    }
}
// EOF
