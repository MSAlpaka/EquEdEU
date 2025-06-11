<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\Lesson;
use Equed\EquedLms\Domain\Model\LessonAttempt;
use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository for LessonAttempt entities.
 */
class LessonAttemptRepository extends Repository
{
    /**
     * Finds the latest attempt by a specific user for a given lesson.
     *
     * @param FrontendUser $user
     * @param Lesson       $lesson
     * @return LessonAttempt|null
     */
    public function findLatestByUserAndLesson(FrontendUser $user, Lesson $lesson): ?LessonAttempt
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd([
                $query->equals('feUser', $user),
                $query->equals('lesson', $lesson),
            ])
        );
        $query->setOrderings(['crdate' => QueryInterface::ORDER_DESCENDING]);
        $query->setLimit(1);

        return $query->execute()->getFirst();
    }

    /**
     * Finds all unfinished lesson attempts (status = 'incomplete').
     *
     * @return LessonAttempt[]
     */
    public function findAllUnfinished(): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('status', 'incomplete')
        );

        return $query->execute()->toArray();
    }

    /**
     * Finds all lesson attempts for a specific frontend user.
     *
     * @param FrontendUser $user
     * @return LessonAttempt[]
     */
    public function findByFeUser(FrontendUser $user): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('feUser', $user)
        );

        return $query->execute()->toArray();
    }
}
// EOF
