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
 * @method CourseInstance[] findAllRequiringExternalExaminer()
 * @method array<int, mixed> findDistinctField(string $field)
 */
interface CourseInstanceRepositoryInterface
{
}
