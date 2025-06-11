<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Service;

use Equed\EquedLms\Domain\Model\CourseGoal;

interface CourseGoalServiceInterface
{
    /**
     * @return CourseGoal[]
     */
    public function getAllCourseGoals(): array;

    /**
     * @param int $courseProgramId
     * @return CourseGoal[]
     */
    public function getGoalsForProgram(int $courseProgramId): array;

    /**
     * @param array<int, object> $userProgress
     */
    public function isGoalMet(array $userProgress, int $goalId): bool;
}
