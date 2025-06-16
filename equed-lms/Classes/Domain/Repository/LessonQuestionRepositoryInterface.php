<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\LessonQuestion;
use Equed\EquedLms\Domain\Model\LessonQuiz;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

interface LessonQuestionRepositoryInterface
{
    /**
     * @param LessonQuiz $lessonQuiz
     * @return LessonQuestion[]
     */
    public function findByLessonQuiz(LessonQuiz $lessonQuiz): array;

    /**
     * @param int $uid
     * @return LessonQuestion|null
     */
    public function findByUid(int $uid): ?LessonQuestion;

    /**
     * @return LessonQuestion[]
     */
    public function findAllActive(): array;

    /**
     * @return QueryInterface<LessonQuestion>
     */
    public function createQuery(): QueryInterface;
}

