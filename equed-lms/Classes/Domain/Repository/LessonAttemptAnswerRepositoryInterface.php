<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\LessonAttempt;
use Equed\EquedLms\Domain\Model\LessonAttemptAnswer;
use Equed\EquedLms\Domain\Model\LessonQuestion;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

interface LessonAttemptAnswerRepositoryInterface
{
    /**
     * @param LessonAttempt $lessonAttempt
     * @return LessonAttemptAnswer[]
     */
    public function findByLessonAttempt(LessonAttempt $lessonAttempt): array;

    /**
     * @param LessonQuestion $question
     * @return LessonAttemptAnswer[]
     */
    public function findCorrectAnswersByQuestion(LessonQuestion $question): array;

    /**
     * @return QueryInterface<LessonAttemptAnswer>
     */
    public function createQuery(): QueryInterface;
}

