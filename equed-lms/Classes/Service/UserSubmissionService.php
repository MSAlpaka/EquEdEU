<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\UserSubmission;
use Equed\EquedLms\Domain\Repository\UserSubmissionRepositoryInterface;

/**
 * Service for retrieving and validating user submissions.
 */
final class UserSubmissionService
{
    public function __construct(
        private readonly UserSubmissionRepositoryInterface $submissionRepository
    ) {
    }

    /**
     * Returns all submissions for a given course instance.
     *
     * @param int $courseInstanceId UID of the course instance
     * @return UserSubmission[] Array of UserSubmission objects
     */
    public function getSubmissionsForCourseInstance(int $courseInstanceId): array
    {
        return $this->submissionRepository->findByCourseInstance($courseInstanceId);
    }

    /**
     * Returns the current feedback status of a submission.
     *
     * @param int $submissionId UID of the submission
     * @return string Feedback status or 'unknown' if not found
     */
    public function getInstructorFeedbackStatus(int $submissionId): string
    {
        $submission = $this->submissionRepository->findByUid($submissionId);

        return $submission !== null
            ? $submission->getStatus()->value
            : 'unknown';
    }

    /**
     * Determines if a submission is validatable (pending validation).
     *
     * @param int $submissionId UID of the submission
     * @return bool True if submission exists and status is SubmissionStatus::Pending
     */
    public function isValidatable(int $submissionId): bool
    {
        $submission = $this->submissionRepository->findByUid($submissionId);

        return $submission !== null
            && $submission->getStatus() === \Equed\EquedLms\Enum\SubmissionStatus::Pending;
    }
}
