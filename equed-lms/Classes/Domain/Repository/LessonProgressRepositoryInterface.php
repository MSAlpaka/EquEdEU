<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\LessonProgress;

interface LessonProgressRepositoryInterface
{
    public function findByUserAndLesson(int $userId, int $lessonId): ?LessonProgress;

    /**
     * @return LessonProgress[]
     */
    public function findByUserId(int $userId): array;

    public function updateOrAdd(LessonProgress $progress): void;

    /**
     * @param int   $userId
     * @param int[] $lessonIds
     */
    public function countCompletedByUserAndLessons(int $userId, array $lessonIds): int;
}
