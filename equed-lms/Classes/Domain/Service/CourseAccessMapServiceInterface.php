<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Service;

/**
 * Provides mapping between course programs and prerequisite goals.
 */
interface CourseAccessMapServiceInterface
{
    /**
     * Returns map of course program IDs to required course goal IDs.
     *
     * @return array<int, int[]>
     */
    public function getCourseAccessMap(): array;
}

