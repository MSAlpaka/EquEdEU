<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\LessonAnswerOption;
use Equed\EquedLms\Domain\Model\LessonQuestion;
use TYPO3\CMS\Extbase\Persistence\Repository;
use Equed\EquedLms\Domain\Repository\LessonAnswerOptionRepositoryInterface;

/**
 * Repository for LessonAnswerOption entities.

 *
 * @extends Repository<LessonAnswerOption>
 */
final class LessonAnswerOptionRepository extends Repository implements LessonAnswerOptionRepositoryInterface
{
    /**
     * Finds all answer options for a specific lesson question.
     *
     * @param LessonQuestion $question
     * @return LessonAnswerOption[]
     */
    public function findByQuestion(LessonQuestion $question): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('question', $question)
        );

        return $query->execute()->toArray();
    }

    /**
     * Finds all correct answer options for a specific lesson question.
     *
     * @param LessonQuestion $question
     * @return LessonAnswerOption[]
     */
    public function findCorrectByQuestion(LessonQuestion $question): array
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
