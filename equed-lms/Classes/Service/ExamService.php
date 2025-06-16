<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Service\ClockInterface;
use Equed\EquedLms\Domain\Service\ExamServiceInterface;
use Equed\EquedLms\Domain\Service\FileReaderInterface;
use Equed\EquedLms\Service\LocalFileReader;
use Equed\EquedLms\Domain\Model\ExamAttempt;
use Equed\EquedLms\Domain\Repository\ExamAttemptRepositoryInterface;
use Equed\EquedLms\Factory\ExamAttemptFactoryInterface;

/**
 * Service to create and manage exam attempts.
 */
final class ExamService implements ExamServiceInterface
{
    private readonly FileReaderInterface $fileReader;

    public function __construct(
        private readonly ExamAttemptRepositoryInterface $examAttemptRepository,
        private readonly ExamAttemptFactoryInterface $examAttemptFactory,
        private readonly ClockInterface $clock,
        private readonly string $templateBasePath,
        ?FileReaderInterface $fileReader = null
    ) {
        $this->fileReader = $fileReader ?? new LocalFileReader();
    }

    /**
     * Create and persist a new exam attempt.
     *
     * @param int $feUserId Frontend user UID
     * @param int $examTemplateId Exam template UID
     * @return ExamAttempt Newly created and persisted exam attempt
     */
    public function createAttempt(int $feUserId, int $examTemplateId): ExamAttempt
    {
        $attempt = $this->examAttemptFactory->createForUserAndTemplate($feUserId, $examTemplateId);
        $this->examAttemptRepository->add($attempt);

        return $attempt;
    }

    /**
     * Mark an exam attempt as scored and persist the change.
     *
     * @param ExamAttempt $attempt Exam attempt entity
     * @param int         $score   Numeric score achieved
     */
    public function markAttemptAsScored(ExamAttempt $attempt, int $score): void
    {
        if (!$attempt->getScored()) {
            $attempt->setScored(true);
            $attempt->setScore($score);
            $attempt->setEndTime($this->clock->now());

            $this->examAttemptRepository->update($attempt);
        }
    }

    /**
     * Retrieve all exam attempts for a user and a specific template.
     *
     * @param int $feUserId     Frontend user UID
     * @param int $templateId   Exam template UID
     * @return ExamAttempt[]    Array of ExamAttempt entities
     */
    public function getAttemptsForUser(int $feUserId, int $templateId): array
    {
        return $this->examAttemptRepository->findByUserAndTemplate($feUserId, $templateId);
    }

    /**
     * Check if the user has a completed (scored) attempt for a specific exam template.
     *
     * @param int $feUserId     Frontend user UID
     * @param int $templateId   Exam template UID
     * @return bool             True if a scored attempt exists, false otherwise
     */
    public function hasCompletedAttempt(int $feUserId, int $templateId): bool
    {
        foreach ($this->getAttemptsForUser($feUserId, $templateId) as $attempt) {
            if ($attempt->getScored() === true) {
                return true;
            }
        }

        return false;
    }

    public function loadTemplate(int $templateId): ?array
    {
        $path = rtrim($this->templateBasePath, '/') . '/' . $templateId . '.json';
        if (!is_file($path)) {
            return null;
        }

        $content = $this->fileReader->read($path);
        if ($content === false) {
            return null;
        }

        return json_decode($content, true) ?: null;
    }

    public function submitAttempt(int $feUserId, int $templateId, array $answers): array
    {
        $attempt = $this->createAttempt($feUserId, $templateId);

        $score = count($answers);
        $this->markAttemptAsScored($attempt, $score);

        return [
            'attemptId' => $attempt->getUid(),
            'score'     => $score,
        ];
    }
}
