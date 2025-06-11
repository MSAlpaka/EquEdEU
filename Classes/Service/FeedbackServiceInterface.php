<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

interface FeedbackServiceInterface
{
    /**
     * @return array<array-key, mixed>|null
     */
    public function getForCourse(int $courseId): array|null;
}
