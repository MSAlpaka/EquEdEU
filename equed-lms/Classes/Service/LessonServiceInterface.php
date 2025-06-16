<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\Lesson;
use Equed\EquedLms\Application\Dto\LessonDto;

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

    /**
     * Retrieves a DTO for the lesson by identifier.
     */
    public function getLessonDtoById(int $lessonId): ?LessonDto;
}
