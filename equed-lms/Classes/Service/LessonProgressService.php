<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use DateTimeImmutable;
use Equed\EquedLms\Domain\Model\Lesson;
use Equed\EquedLms\Domain\Model\LessonProgress;
use Equed\EquedLms\Domain\Repository\LessonProgressRepositoryInterface;
use Equed\EquedLms\Domain\Model\FrontendUser;

/**
 * Service to manage lesson progress for users.
 */
final class LessonProgressService
{
    public function __construct(
        private readonly LessonProgressRepositoryInterface $progressRepository
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

        $progress->setStatus('completed');
        $progress->setCompleted(true);
        $progress->setCompletedAt(new DateTimeImmutable());

        $this->progressRepository->updateOrAdd($progress);

        return $progress;
    }
}
