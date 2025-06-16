<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Repository\UserCourseRecordRepositoryInterface;
use Equed\EquedLms\Domain\Service\UserAccessServiceInterface;

/**
 * Service for checking user access and instructor validation.
 */
final class UserAccessService implements UserAccessServiceInterface
{
    public function __construct(
        private readonly UserCourseRecordRepositoryInterface $userCourseRecordRepository
    ) {
    }

    /**
     * Check if a user has access to a specific course program.
     *
     * @param int $userId ID of the frontend user
     * @param int $courseProgramId UID of the course program
     * @return bool True if the user has at least one course record for the program
     */
    public function canAccessCourse(int $userId, int $courseProgramId): bool
    {
        return $this->userCourseRecordRepository->countByUserIdAndCourseProgram(
            $userId,
            $courseProgramId
        ) > 0;
    }

    /**
     * Check if the given user is the instructor for a specific course record.
     *
     * @param int $instructorUserId ID of the frontend user (instructor)
     * @param int $userCourseRecordId UID of the UserCourseRecord
     * @return bool True if the user is the instructor of the record
     */
    public function canValidateAsInstructor(int $instructorUserId, int $userCourseRecordId): bool
    {
        $record = $this->userCourseRecordRepository->findByUid($userCourseRecordId);
        if ($record === null) {
            return false;
        }

        $instructor = $record->getCourseInstance()->getInstructor();
        return $instructor !== null
            && $instructor->getUid() === $instructorUserId;
    }
}
