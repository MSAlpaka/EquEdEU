<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\UserSubmission;
use Equed\EquedLms\Domain\Repository\UserSubmissionRepositoryInterface;

/**
 * Service for managing user submissions.
 */
final class SubmissionService
{
    public function __construct(
        private readonly UserSubmissionRepositoryInterface $submissionRepository
    ) {
    }

    /**
     * Returns pending submissions for a given instructor.
     *
     * @param int $instructorFeUser FE user ID of the instructor
     * @return UserSubmission[] Array of pending UserSubmission objects
     */
    public function getPendingSubmissions(int $instructorFeUser): array
    {
        return $this->submissionRepository->findPendingSubmissionsForInstructor($instructorFeUser);
    }

    /**
     * Returns the number of submissions for a specific course instance.
     *
     * @param int $courseInstanceId UID of the course instance
     * @return int Number of submissions
     */
    public function countSubmissionsForCourse(int $courseInstanceId): int
    {
        return $this->submissionRepository->countByCourseInstance($courseInstanceId);
    }

    /**
     * Returns all submissions for a given user.
     *
     * @param int $feUser FE user ID
     * @return UserSubmission[] Array of UserSubmission objects
     */
    public function getAllForUser(int $feUser): array
    {
        return $this->submissionRepository->findByFeUser($feUser);
    }
}
