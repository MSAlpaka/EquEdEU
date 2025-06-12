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

 *
 * @extends Repository<Lesson>
 */
final class LessonRepository extends Repository
{
    /**
     * Finds all lessons for a given course program via the module relation.
     *
     * @param CourseProgram $courseProgram
     * @return Lesson[]
     */
    public function findByCourseProgram(CourseProgram $courseProgram): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('module.courseProgram', $courseProgram)
        );

        return $query->execute()->toArray();
    }

    /**
     * Find all lessons marked as visible.
     *
     * @return Lesson[]
     */
    public function findVisible(): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('visible', true)
        );

        return $query->execute()->toArray();
    }

    /**
     * Find lessons that contain quiz questions.
     *
     * @return Lesson[]
     */
    public function findWithQuiz(): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->greaterThan('quiz.uid', 0)
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
