<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\Lesson;
use Equed\EquedLms\Domain\Model\LessonAttempt;
use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;
use Equed\EquedLms\Domain\Repository\LessonAttemptRepositoryInterface;

/**
 * Repository for LessonAttempt entities.

 *
 * @extends Repository<LessonAttempt>
 */
final class LessonAttemptRepository extends Repository implements LessonAttemptRepositoryInterface
{
    /**
     * Finds the latest attempt by a specific instructor for a given lesson.
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
                $query->equals('instructor', $user),
                $query->equals('lesson', $lesson),
            ])
        );
        $query->setOrderings(['createdAt' => QueryInterface::ORDER_DESCENDING]);
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
     * Finds all lesson attempts for a specific instructor.
     *
     * @param FrontendUser $user
     * @return LessonAttempt[]
     */
    public function findByFeUser(FrontendUser $user): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('instructor', $user)
        );

        return $query->execute()->toArray();
    }
}
