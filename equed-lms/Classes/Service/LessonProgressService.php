<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Service\ClockInterface;
use Equed\EquedLms\Domain\Model\Lesson;
use Equed\EquedLms\Domain\Model\LessonProgress;
use Equed\EquedLms\Domain\Repository\LessonProgressRepositoryInterface;
use Equed\EquedLms\Domain\Repository\LessonRepositoryInterface;
use Equed\EquedLms\Domain\Repository\UserCourseRecordRepositoryInterface;
use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Domain\Service\LessonProgressServiceInterface;
use Equed\EquedLms\Enum\ProgressStatus;
use Equed\EquedLms\Event\Progress\LessonProgressUpdatedEvent;
use Equed\EquedLms\Event\Progress\LessonProgressCompletedEvent;
use Psr\EventDispatcher\EventDispatcherInterface;
use Equed\EquedLms\Domain\Factory\LessonProgressFactoryInterface;

/**
 * Service to manage lesson progress for users.
 */
final class LessonProgressService implements LessonProgressServiceInterface
{
    public function __construct(
        private readonly LessonProgressRepositoryInterface $progressRepository,
        private readonly LessonRepositoryInterface $lessonRepository,
        private readonly UserCourseRecordRepositoryInterface $courseRecordRepository,
        private readonly ClockInterface $clock,
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly LessonProgressFactoryInterface $progressFactory,
    ) {
    }

    /**
     * Get progress status for a given user and lesson.
     *
     * @param FrontendUser $user
     * @param Lesson       $lesson
     * @return LessonProgress|null
     */
    public function getProgressEntity(FrontendUser $user, Lesson $lesson): ?LessonProgress
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
        $progress = $this->getProgressEntity($user, $lesson);

        if ($progress === null) {
            $progress = $this->progressFactory->create();
            $records = $this->courseRecordRepository->findByUserId((int) $user->getUid());
            $progress->setUserCourseRecord($records[0] ?? null);
            $progress->setLesson($lesson);
        }

        $progress->setStatus(ProgressStatus::Completed);
        $progress->setCompleted(true);
        $progress->setCompletedAt($this->clock->now());

        $this->progressRepository->updateOrAdd($progress);
        $this->eventDispatcher->dispatch(new LessonProgressUpdatedEvent($progress));
        $this->eventDispatcher->dispatch(new LessonProgressCompletedEvent($progress));

        return $progress;
    }

    public function getProgress(int $userId, int $lessonId): ?LessonProgress
    {
        return $this->progressRepository->findByUserAndLesson($userId, $lessonId);
    }

    public function setProgress(int $userId, int $lessonId, bool $completed): LessonProgress
    {
        $progress = $this->progressRepository->findByUserAndLesson($userId, $lessonId);

        if ($progress === null) {
            $lesson = $this->lessonRepository->findByUid($lessonId);
            $progress = $this->progressFactory->create();
            $records = $this->courseRecordRepository->findByUserId($userId);
            $progress->setUserCourseRecord($records[0] ?? null);
            if ($lesson instanceof Lesson) {
                $progress->setLesson($lesson);
            }
        }

        $progress->setStatus($completed ? ProgressStatus::Completed : ProgressStatus::InProgress);
        $progress->setCompleted($completed);
        if ($completed) {
            $progress->setCompletedAt($this->clock->now());
        }

        $this->progressRepository->updateOrAdd($progress);
        $this->eventDispatcher->dispatch(new LessonProgressUpdatedEvent($progress));
        if ($completed) {
            $this->eventDispatcher->dispatch(new LessonProgressCompletedEvent($progress));
        }

        return $progress;
    }
}
