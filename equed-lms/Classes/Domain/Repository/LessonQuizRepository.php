<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\Lesson;
use Equed\EquedLms\Domain\Model\LessonQuiz;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository for LessonQuiz entities.

 *
 * @extends Repository<LessonQuiz>
 */
final class LessonQuizRepository extends Repository
{
    /**
     * Finds all quizzes for a given lesson.
     *
     * @param Lesson $lesson
     * @return LessonQuiz[]
     */
    public function findByLesson(Lesson $lesson): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('lesson', $lesson)
        );

        return $query->execute()->toArray();
    }

    /**
     * Finds all quizzes for a given lesson and language.
     *
     * @param Lesson $lesson
     * @param string $language
     * @return LessonQuiz[]
     */
    public function findByLessonAndLanguage(Lesson $lesson, string $language): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd([
                $query->equals('lesson', $lesson),
                $query->equals('language', $language),
            ])
        );

        return $query->execute()->toArray();
    }
}
// EOF
