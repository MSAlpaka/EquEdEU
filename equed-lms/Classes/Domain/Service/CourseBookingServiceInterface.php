<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Service;

interface CourseBookingServiceInterface
{
    /**
     * Check if a user already has a booking for the given course instance.
     */
    public function isAlreadyBooked(int $userId, int $courseInstanceId): bool;

    /**
     * Book a course instance for a user.
     */
    public function bookCourse(int $userId, int $courseInstanceId): void;
}

