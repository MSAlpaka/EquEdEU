<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

interface CourseServiceInterface
{
    /**
     * @return array<array-key, mixed>
     */
    public function getAvailableCourses(): array;

    /**
     * @return array<array-key, mixed>|null
     */
    public function getCourseById(int $id): array|null;
}
