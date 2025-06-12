<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\Lesson;
use Equed\EquedLms\Domain\Model\UserCourseRecord;
use Equed\EquedLms\Domain\Repository\LessonRepositoryInterface;
use Equed\EquedLms\Domain\Repository\UserSubmissionRepositoryInterface;
use Equed\EquedLms\Dto\UserProgress;

/**
 * Service for calculating user progress within a course program.
 */
final class UserProgressService
{
    private const SUBMISSION_FACTOR = 0.2;
    private const QUIZ_FACTOR = 0.2;
    private const LESSON_FACTOR = 1.0 - self::SUBMISSION_FACTOR - self::QUIZ_FACTOR;

    public function __construct(
        private readonly LessonRepositoryInterface $lessonRepository,
        private readonly UserSubmissionRepositoryInterface $userSubmissionRepository
    ) {
    }

    /**
     * Calculate overall progress percentage and lesson completion counts.
     */
    public function calculate(UserCourseRecord $ucr): UserProgress
    {
        $program = $ucr->getCourseInstance()?->getCourseProgram();
        if ($program === null) {
            return new UserProgress(0, 0, 0);
        }

        $requiredLessons = $this->lessonRepository->findRequiredByCourseProgram($program->getUid());
        $totalCount = count($requiredLessons);
        $completedCount = count(array_filter(
            $requiredLessons,
            fn (Lesson $lesson): bool => $ucr->hasCompletedLesson($lesson)
        ));

        $submissionScore = $this->calculateSubmissionScore(
            $this->userSubmissionRepository->findScoresByUserCourseRecord((int) $ucr->getUid())
        );

        $quizScore = $ucr->getQuizScorePercent() ?? 0.0;

        $lessonProgress = $totalCount > 0 ? $completedCount / $totalCount : 0.0;

        $progress = ($lessonProgress * self::LESSON_FACTOR)
            + ($submissionScore * self::SUBMISSION_FACTOR)
            + (($quizScore / 100.0) * self::QUIZ_FACTOR);

        return new UserProgress(
            (int) round($progress * 100.0),
            $completedCount,
            $totalCount
        );
    }

    /**
     * Calculate normalized submission score between 0.0 and 1.0.
     *
     * @param array<int,array{points:float|null,maxPoints:float|null}> $submissions
     * @return float
     */
    private function calculateSubmissionScore(array $submissions): float
    {
        $earned = 0.0;
        $max = 0.0;

        foreach ($submissions as $submission) {
            $earned += $submission['points'] ?? 0.0;
            $max    += $submission['maxPoints'] ?? 0.0;
        }

        return $max > 0.0 ? min(1.0, $earned / $max) : 0.0;
    }
}
