<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Repository\CourseGoalRepositoryInterface;
use Equed\EquedLms\Domain\Service\CourseAccessMapServiceInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

/**
 * Generates the course access map from course goal definitions.
 */
final class CourseAccessMapService implements CourseAccessMapServiceInterface
{
    public function __construct(
        private readonly CourseGoalRepositoryInterface $courseGoalRepository,
    ) {
    }

    public function getCourseAccessMap(): array
    {
        $goals = $this->courseGoalRepository->findAll();
        if ($goals instanceof QueryResultInterface) {
            $goals = $goals->toArray();
        }

        $map = [];
        foreach ($goals as $goal) {
            if (!method_exists($goal, 'isRequiredForCourseAccess') || !$goal->isRequiredForCourseAccess()) {
                continue;
            }

            $programId = $goal->getCourseProgram();
            $map[$programId][] = $goal->getUid();
        }

        return $map;
    }
}

