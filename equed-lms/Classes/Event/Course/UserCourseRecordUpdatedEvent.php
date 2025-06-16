<?php

declare(strict_types=1);

namespace Equed\EquedLms\Event\Course;

use Equed\EquedLms\Domain\Model\UserCourseRecord;

/**
 * Event dispatched when a user course record is updated.
 */
final class UserCourseRecordUpdatedEvent
{
    public function __construct(
        private readonly UserCourseRecord $userCourseRecord,
        private readonly string $property
    ) {
    }

    /**
     * The updated user course record.
     */
    public function getUserCourseRecord(): UserCourseRecord
    {
        return $this->userCourseRecord;
    }

    /**
     * Name of the property that triggered the event.
     */
    public function getProperty(): string
    {
        return $this->property;
    }
}

