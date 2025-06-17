<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\UserSubmission;
use Equed\EquedLms\Domain\Repository\UserSubmissionRepositoryInterface;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Equed\EquedLms\Event\Submission\SubmissionReviewedEvent;
use Equed\EquedLms\Domain\Service\ClockInterface;
use Equed\EquedLms\Dto\SubmissionCreateRequest;
use Equed\EquedLms\Dto\SubmissionEvaluateRequest;
use InvalidArgumentException;
use Equed\EquedLms\Service\LogService;
use Equed\EquedLms\Domain\Service\LanguageServiceInterface;
use Equed\EquedLms\Service\TranslatedLoggerTrait;

/**
 * Service for managing user submissions.
 */
final class SubmissionService
{
    use TranslatedLoggerTrait;

    public function __construct(
        private readonly UserSubmissionRepositoryInterface $submissionRepository,
        private readonly PersistenceManagerInterface $persistenceManager,
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly ClockInterface $clock,
        LanguageServiceInterface $translationService,
        LogService $logService,
    ) {
        $this->injectTranslatedLogger($translationService, $logService);
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

    public function createSubmission(SubmissionCreateRequest $request): void
    {
        if ($request->getRecordId() <= 0 || $request->getFile() === '') {
            $this->logTranslatedError('submission.create.invalid');
            throw new InvalidArgumentException('Missing required fields');
        }

        $now = $this->clock->now()->getTimestamp();
        $this->submissionRepository->createSubmission(
            $request->getUserId(),
            $request->getRecordId(),
            $request->getNote(),
            $request->getFile(),
            $request->getType(),
            $now
        );
        $this->persistenceManager->persistAll();
    }

    public function evaluateSubmission(SubmissionEvaluateRequest $request): void
    {
        if ($request->getSubmissionId() <= 0 || $request->getEvaluationNote() === '') {
            $this->logTranslatedError('submission.evaluate.invalid');
            throw new InvalidArgumentException('Missing required fields');
        }

        $now = $this->clock->now()->getTimestamp();
        $this->submissionRepository->updateSubmission(
            $request->getSubmissionId(),
            $request->getEvaluationNote(),
            $request->getEvaluationFile(),
            $request->getComment(),
            $request->getEvaluatorId(),
            $now
        );
        $this->persistenceManager->persistAll();

        $submission = $this->submissionRepository->findByUid($request->getSubmissionId());
        if ($submission instanceof UserSubmission) {
            $this->eventDispatcher->dispatch(new SubmissionReviewedEvent($submission));
        }
    }

}
