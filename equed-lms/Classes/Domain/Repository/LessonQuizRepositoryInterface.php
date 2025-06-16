<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\Lesson;
use Equed\EquedLms\Domain\Model\LessonQuiz;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

interface LessonQuizRepositoryInterface
{
    /**
     * @param Lesson $lesson
     * @return LessonQuiz[]
     */
    public function findByLesson(Lesson $lesson): array;

    /**
     * @param Lesson $lesson
     * @param string $language
     * @return LessonQuiz[]
     */
    public function findByLessonAndLanguage(Lesson $lesson, string $language): array;

    /**
     * @return QueryInterface<LessonQuiz>
     */
    public function createQuery(): QueryInterface;
}

