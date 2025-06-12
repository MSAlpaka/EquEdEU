<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\CourseInstance;

/**
 * Interface for course instance repository
 *
 * @method CourseInstance|null findByUid(int $uid)
 * @method CourseInstance[] findByInstructor(int $instructorId)
 * @method CourseInstance[] findByCourseProgram(int $courseProgramId)
 */
interface CourseInstanceRepositoryInterface
{
    /**
     * @return CourseInstance[]
     */
    public function findAllRequiringExternalExaminer(): array;

    /**
     * @param string $field
     * @return array<int, mixed>
     */
    public function findDistinctField(string $field): array;
}
