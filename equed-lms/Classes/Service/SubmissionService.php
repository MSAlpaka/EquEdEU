<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\UserSubmission;
use Equed\EquedLms\Domain\Repository\UserSubmissionRepositoryInterface;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;

/**
 * Service for managing user submissions.
 */
final class SubmissionService
{
    public function __construct(
        private readonly UserSubmissionRepositoryInterface $submissionRepository,
        private readonly ConnectionPool $connectionPool,
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
        $now = time();
        $this->getConnection()->insert(
            'tx_equedlms_domain_model_usersubmission',
            [
                'fe_user'          => $userId,
                'usercourserecord' => $recordId,
                'note'             => $note,
                'file'             => $file,
                'type'             => $type,
                'submitted_at'     => $now,
                'status'           => 'submitted',
                'crdate'           => $now,
                'tstamp'           => $now,
            ]
        );
    }

    public function evaluateSubmission(int $submissionId, string $evaluationNote, string $evaluationFile, string $comment, int $evaluatorId): void
    {
        $now = time();
        $this->getConnection()->update(
            'tx_equedlms_domain_model_usersubmission',
            [
                'evaluation_note'    => $evaluationNote,
                'evaluation_file'    => $evaluationFile,
                'instructor_comment' => $comment,
                'evaluated_by'       => $evaluatorId,
                'evaluated_at'       => $now,
                'status'             => 'evaluated',
                'tstamp'             => $now,
            ],
            ['uid' => $submissionId]
        );
    }

    private function getConnection(): Connection
    {
        return $this->connectionPool->getConnectionForTable('tx_equedlms_domain_model_usersubmission');
    }
}
