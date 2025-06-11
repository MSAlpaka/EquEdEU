<?php

declare(strict_types=1);

namespace Equed\EquedLms\Event\Course;

use Equed\EquedLms\Domain\Model\UserCourseRecord;

/**
 * Event emitted when a user completes a course.
 */
final class CourseCompletedEvent
{
    private readonly UserCourseRecord $userCourseRecord;

    /**
     * @param UserCourseRecord $userCourseRecord The record of the completed course
     */
    public function __construct(UserCourseRecord $userCourseRecord)
    {
        $this->userCourseRecord = $userCourseRecord;
    }

    /**
     * Returns the user course record for the completed course.
     */
    public function getUserCourseRecord(): UserCourseRecord
    {
        return $this->userCourseRecord;
    }
}
// EOF
