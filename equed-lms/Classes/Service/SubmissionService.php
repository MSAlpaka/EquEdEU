<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\UserSubmission;
use Equed\EquedLms\Domain\Repository\UserSubmissionRepositoryInterface;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Equed\EquedLms\Event\Submission\SubmissionReviewedEvent;
use Equed\EquedLms\Domain\Service\ClockInterface;

/**
 * Service for managing user submissions.
 */
final class SubmissionService
{
    public function __construct(
        private readonly UserSubmissionRepositoryInterface $submissionRepository,
        private readonly PersistenceManagerInterface $persistenceManager,
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly ClockInterface $clock,
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

    public function createSubmission(int $userId, int $recordId, string $note, string $file, string $type): void
    {
        $now = $this->clock->now()->getTimestamp();
        $this->submissionRepository->createSubmission(
            $userId,
            $recordId,
            $note,
            $file,
            $type,
            $now
        );
        $this->persistenceManager->persistAll();
    }

    public function evaluateSubmission(int $submissionId, string $evaluationNote, string $evaluationFile, string $comment, int $evaluatorId): void
    {
        $now = $this->clock->now()->getTimestamp();
        $this->submissionRepository->updateSubmission(
            $submissionId,
            $evaluationNote,
            $evaluationFile,
            $comment,
            $evaluatorId,
            $now
        );
        $this->persistenceManager->persistAll();

        $submission = $this->submissionRepository->findByUid($submissionId);
        if ($submission instanceof UserSubmission) {
            $this->eventDispatcher->dispatch(new SubmissionReviewedEvent($submission));
        }
    }

}
