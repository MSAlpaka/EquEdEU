<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\CourseProgram;
use Equed\EquedLms\Domain\Model\Lesson;
use Equed\EquedLms\Domain\Model\Module;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository for Lesson entities.
 */
final class LessonRepository extends Repository
{
    /**
     * Finds all lessons for a given course program.
     *
     * @param CourseProgram $courseProgram
     * @return Lesson[]
     */
    public function findByCourseProgram(CourseProgram $courseProgram): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('courseProgram', $courseProgram)
        );

        return $query->execute()->toArray();
    }

    /**
     * Finds all visible lessons (hidden = false).
     *
     * @return Lesson[]
     */
    public function findVisibleLessons(): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('hidden', 0)
        );

        return $query->execute()->toArray();
    }

    /**
     * Finds all lessons that have a quiz associated.
     *
     * @return Lesson[]
     */
    public function findQuizLessonsOnly(): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('hasQuiz', true)
        );

        return $query->execute()->toArray();
    }

    /**
     * Find all lessons for a specific module.
     *
     * @param Module $module
     * @return Lesson[]
     */
    public function findByModule(Module $module): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('module', $module)
        );

        return $query->execute()->toArray();
    }

    /**
     * Find a lesson by its UUID.
     *
     * @param string $uuid
     * @return Lesson|null
     */
    public function findByUuid(string $uuid): ?Lesson
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('uuid', $uuid)
        );
        $query->setLimit(1);

        return $query->execute()->getFirst();
    }
}
// EOF
