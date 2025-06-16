<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Service;

use Equed\EquedLms\Domain\Model\ExamAttempt;

interface ExamServiceInterface
{
    /**
     * Create and persist a new exam attempt.
     *
     * @param int $feUserId       Frontend user UID
     * @param int $examTemplateId Exam template UID
     * @return ExamAttempt Newly created and persisted exam attempt
     */
    public function createAttempt(int $feUserId, int $examTemplateId): ExamAttempt;

    /**
     * Mark an exam attempt as scored and persist the change.
     *
     * @param ExamAttempt $attempt Exam attempt entity
     * @param int         $score   Numeric score achieved
     */
    public function markAttemptAsScored(ExamAttempt $attempt, int $score): void;

    /**
     * Retrieve all exam attempts for a user and a specific template.
     *
     * @param int $feUserId   Frontend user UID
     * @param int $templateId Exam template UID
     * @return ExamAttempt[]  Array of ExamAttempt entities
     */
    public function getAttemptsForUser(int $feUserId, int $templateId): array;

    /**
     * Check if the user has a completed (scored) attempt for a specific exam template.
     *
     * @param int $feUserId   Frontend user UID
     * @param int $templateId Exam template UID
     * @return bool           True if a scored attempt exists, false otherwise
     */
    public function hasCompletedAttempt(int $feUserId, int $templateId): bool;

    /**
     * Load an exam template with questions.
     *
     * @param int $templateId Template UID
     * @return array|null     Template data or null if not found
     */
    public function loadTemplate(int $templateId): ?array;

    /**
     * Submit answers for an exam template and return the result.
     *
     * @param int          $feUserId   Frontend user UID
     * @param int          $templateId Exam template UID
     * @param array<mixed> $answers    Submitted answers
     * @return array<string,mixed>     Result data
     */
    public function submitAttempt(int $feUserId, int $templateId, array $answers): array;
}
