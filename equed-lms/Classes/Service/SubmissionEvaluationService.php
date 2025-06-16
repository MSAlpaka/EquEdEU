<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\UserSubmission;
use Equed\EquedLms\Domain\Repository\UserSubmissionRepositoryInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use Equed\EquedLms\Domain\Service\ClockInterface;
use Equed\EquedLms\Event\Submission\SubmissionReviewedEvent;
use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * Service to evaluate user submissions manually or assisted by GPT.
 */
final class SubmissionEvaluationService
{
    public function __construct(
        private readonly UserSubmissionRepositoryInterface $submissionRepository,
        private readonly GptTranslationServiceInterface $translationService,
        private readonly PersistenceManagerInterface $persistenceManager,
        private readonly ClockInterface $clock,
        private readonly EventDispatcherInterface $eventDispatcher,
    ) {
    }

    /**
     * Evaluates a submission by assigning a score and summary.
     *
     * @param UserSubmission $submission
     * @param int            $score 0–100
     * @param string         $feedback Evaluator's comments
     * @return void
     */
    public function evaluateSubmission(UserSubmission $submission, int $score, string $feedback): void
    {
        $submission->setScore($score);
        $submission->setFeedback($feedback);
        $submission->setScored(true);
        $submission->setEvaluatedAt($this->clock->now());

        $this->submissionRepository->update($submission);
        $this->persistenceManager->persistAll();
        $this->eventDispatcher->dispatch(new SubmissionReviewedEvent($submission));
    }

    /**
     * Generates GPT-assisted rubric feedback if enabled.
     *
     * @param UserSubmission $submission
     * @return string|null
     */
    public function generateRubricFeedback(UserSubmission $submission): ?string
    {
        if (! $this->translationService->isEnabled()) {
            return null;
        }

        $prompt = $this->translationService->translate(
            'submission.evaluation.prompt',
            ['text' => $submission->getContent()],
            'equed_lms'
        );

        return $prompt ?? null;
    }
}
