<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\Lesson;

/**
 * Contract for lesson related data retrieval.
 */
interface LessonServiceInterface
{
    /**
     * Builds a structured lesson data array.
     *
     * @param Lesson $lesson
     * @return array<string, mixed>
     */
    public function getLessonDataArray(Lesson $lesson): array;

    /**
     * Retrieves lesson data by identifier.
     *
     * @param int $lessonId
     * @return array<string, mixed>|null
     */
    public function getLessonDataById(int $lessonId): ?array;
}
