<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\CourseGoal;
use Equed\EquedLms\Domain\Repository\CourseGoalRepositoryInterface;
use Equed\EquedLms\Domain\Service\CourseGoalServiceInterface;

/**
 * Service to manage course goals retrieval and evaluation.
 */
final class CourseGoalService implements CourseGoalServiceInterface
{
    /**
     * In-memory cache for course goals per program.
     *
     * @var array<int, CourseGoal[]>
     */
    private array $goalsCache = [];

    public function __construct(
        private readonly CourseGoalRepositoryInterface $courseGoalRepository
    ) {
    }

    /**
     * {@inheritDoc}
     *
     * @return CourseGoal[]
     */
    public function getAllCourseGoals(): array
    {
        $result = $this->courseGoalRepository->findAll();
        if ($result instanceof \TYPO3\CMS\Extbase\Persistence\QueryResultInterface) {
            /** @var CourseGoal[] $goals */
            $goals = $result->toArray();
        } else {
            /** @var CourseGoal[] $goals */
            $goals = $result;
        }

        return $goals;
    }

    /**
     * @inheritDoc
     */
    public function getGoalsForProgram(int $courseProgramId): array
    {
        return $this->getGoalsForCourseProgram($courseProgramId);
    }

    /**
     * Retrieve all goals associated with a given course program.
     *
     * @param int $courseProgramId CourseProgram UID
     * @return CourseGoal[] List of CourseGoal entities
     */
    public function getGoalsForCourseProgram(int $courseProgramId): array
    {
        if (!isset($this->goalsCache[$courseProgramId])) {
            $this->goalsCache[$courseProgramId] = $this->courseGoalRepository->findByCourseProgram($courseProgramId);
        }

        return $this->goalsCache[$courseProgramId];
    }

    /**
     * Determine if a specific goal has been met based on user progress.
     *
     * @param object[] $userProgress Array of progress items with getLesson() and getStatus()
     * @param int      $goalId       CourseGoal UID
     * @return bool True if the goal is met, false otherwise
     */
    public function isGoalMet(array $userProgress, int $goalId): bool
    {
        foreach ($userProgress as $progress) {
            $lesson = $progress->getLesson();
            $goal = $lesson?->getCourseGoal();

            if ($goal?->getUid() === $goalId && $progress->getStatus() === 'completed') {
                return true;
            }
        }

        return false;
    }
}
