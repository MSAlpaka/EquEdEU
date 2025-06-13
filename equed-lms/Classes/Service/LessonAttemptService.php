<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\LessonAttempt;
use Equed\EquedLms\Domain\Repository\LessonAttemptRepositoryInterface;

/**
 * Service for handling lesson attempts.
 */
final class LessonAttemptService
{
    public function __construct(
        private readonly LessonAttemptRepositoryInterface $lessonAttemptRepository
    ) {
    }

    /**
     * Returns the latest attempt of a user for a given lesson.
     *
     * @param int $userId   ID of the frontend user
     * @param int $lessonId ID of the lesson
     *
     * @return LessonAttempt|null
     */
    public function getLatestAttemptForLesson(int $userId, int $lessonId): ?LessonAttempt
    {
        return $this->lessonAttemptRepository->findLatestByUserAndLesson($userId, $lessonId);
    }

    /**
     * Checks whether there is an unfinished attempt of a user for a given lesson.
     *
     * @param int $userId   ID of the frontend user
     * @param int $lessonId ID of the lesson
     *
     * @return bool
     */
    public function hasUnfinishedAttempt(int $userId, int $lessonId): bool
    {
        $latestAttempt = $this->getLatestAttemptForLesson($userId, $lessonId);

        return $latestAttempt !== null
            && $latestAttempt->getStatus() !== 'completed';
    }
}
