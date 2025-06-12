<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\LessonAttempt;
use Equed\EquedLms\Domain\Model\LessonAttemptAnswer;
use Equed\EquedLms\Domain\Model\LessonQuestion;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository for LessonAttemptAnswer entities.
 */
final class LessonAttemptAnswerRepository extends Repository
{
    /**
     * Finds all answers for a specific lesson attempt.
     *
     * @param LessonAttempt $lessonAttempt
     * @return LessonAttemptAnswer[]
     */
    public function findByLessonAttempt(LessonAttempt $lessonAttempt): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('lessonAttempt', $lessonAttempt)
        );

        return $query->execute()->toArray();
    }

    /**
     * Finds all correct answers for a specific lesson question.
     *
     * @param LessonQuestion $question
     * @return LessonAttemptAnswer[]
     */
    public function findCorrectAnswersByQuestion(LessonQuestion $question): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd([
                $query->equals('question', $question),
                $query->equals('isCorrect', true),
            ])
        );

        return $query->execute()->toArray();
    }
}
// EOF
