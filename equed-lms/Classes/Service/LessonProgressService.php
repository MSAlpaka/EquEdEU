<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Service\ClockInterface;
use Equed\EquedLms\Domain\Model\Lesson;
use Equed\EquedLms\Domain\Model\LessonProgress;
use Equed\EquedLms\Domain\Repository\LessonProgressRepositoryInterface;
use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Enum\ProgressStatus;

/**
 * Service to manage lesson progress for users.
 */
final class LessonProgressService
{
    public function __construct(
        private readonly LessonProgressRepositoryInterface $progressRepository,
        private readonly ClockInterface $clock
    ) {
    }

    /**
     * Get progress status for a given user and lesson.
     *
     * @param FrontendUser $user
     * @param Lesson       $lesson
     * @return LessonProgress|null
     */
    public function getProgress(FrontendUser $user, Lesson $lesson): ?LessonProgress
    {
        return $this->progressRepository->findByUserAndLesson(
            (int) $user->getUid(),
            $lesson->getUid()
        );
    }

    /**
     * Mark lesson as completed for user.
     *
     * @param FrontendUser $user
     * @param Lesson       $lesson
     * @return LessonProgress
     */
    public function setProgressCompleted(FrontendUser $user, Lesson $lesson): LessonProgress
    {
        $progress = $this->getProgress($user, $lesson);

        if ($progress === null) {
            $progress = new LessonProgress();
            $progress->setFeUser((int) $user->getUid());
            $progress->setLesson($lesson);
        }

        $progress->setStatus(ProgressStatus::Completed);
        $progress->setCompleted(true);
        $progress->setCompletedAt($this->clock->now());

        $this->progressRepository->updateOrAdd($progress);

        return $progress;
    }
}
