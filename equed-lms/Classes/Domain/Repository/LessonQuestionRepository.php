<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\LessonQuestion;
use Equed\EquedLms\Domain\Model\LessonQuiz;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository for LessonQuestion entities.

 *
 * @extends Repository<LessonQuestion>
 */
final class LessonQuestionRepository extends Repository
{
    /**
     * Finds all questions for a given lesson quiz.
     *
     * @param LessonQuiz $lessonQuiz
     * @return LessonQuestion[]
     */
    public function findByLessonQuiz(LessonQuiz $lessonQuiz): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('lessonQuiz', $lessonQuiz)
        );

        return $query->execute()->toArray();
    }

    /**
     * Find a question by its UID.
     *
     * @param int $uid
     * @return LessonQuestion|null
     */
    public function findByUid(int $uid): ?LessonQuestion
    {
        return $this->findByIdentifier($uid);
    }

    /**
     * Finds all active questions (not marked deleted).
     *
     * @return LessonQuestion[]
     */
    public function findAllActive(): array
    {
        return $this->createQuery()
            ->execute()
            ->toArray();
    }
}
// EOF
