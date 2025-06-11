<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

interface LessonServiceInterface
{
    /**
     * @return array<array-key, mixed>
     */
    public function getAllForCurrentUser(): array;

    /**
     * @return array<array-key, mixed>|null
     */
    public function findById(int $lessonId): array|null;
}
