<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\CourseProgram;
use Equed\EquedLms\Domain\Model\Lesson;
use Equed\EquedLms\Domain\Model\Module;

interface LessonRepositoryInterface
{
    /**
     * @param CourseProgram $courseProgram
     * @return Lesson[]
     */
    public function findByCourseProgram(CourseProgram $courseProgram): array;

    /**
     * @return Lesson[]
     */
    public function findVisible(): array;

    /**
     * @return Lesson[]
     */
    public function findWithQuiz(): array;

    /**
     * @param Module $module
     * @return Lesson[]
     */
    public function findByModule(Module $module): array;

    public function findByUuid(string $uuid): ?Lesson;

    /**
     * Count lessons for a module.
     */
    public function countByModule(Module $module): int;

    /**
     * Count lessons that contain quiz questions.
     */
    public function countWithQuiz(): int;
}
