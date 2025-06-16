<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\LessonAnswerOption;
use Equed\EquedLms\Domain\Model\LessonQuestion;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

interface LessonAnswerOptionRepositoryInterface
{
    /**
     * @param LessonQuestion $question
     * @return LessonAnswerOption[]
     */
    public function findByQuestion(LessonQuestion $question): array;

    /**
     * @param LessonQuestion $question
     * @return LessonAnswerOption[]
     */
    public function findCorrectByQuestion(LessonQuestion $question): array;

    /**
     * @return QueryInterface<LessonAnswerOption>
     */
    public function createQuery(): QueryInterface;
}

