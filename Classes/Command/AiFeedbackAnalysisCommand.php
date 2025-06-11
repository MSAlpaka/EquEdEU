<?php

declare(strict_types=1);

namespace Equed\EquedLms\Command;

use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Repository\FeedbackRepositoryInterface;
use Equed\EquedLms\Domain\Repository\SubmissionRepositoryInterface;
use Equed\EquedLms\Domain\Service\AiFeedbackAnalyzerInterface;
use Equed\EquedLms\Domain\Service\FeedbackAnalysisResultPersisterInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Executes the weekly GPT-based analysis of course feedback and text submissions.
 *
 * The command respects feature toggles, processes pending entities via domain repositories,
 * and stores structured analysis results. All user-facing output is translated by
 * {@see GptTranslationServiceInterface} with automatic fallback handling.
 */
#[AsCommand(
    name: AiFeedbackAnalysisCommand::COMMAND_NAME,
    description: 'Runs the GPT-based analysis of course feedback and submissions.'
)]
final class AiFeedbackAnalysisCommand extends Command
{
    public const COMMAND_NAME = 'equed:ai:feedback-analyze';

    public function __construct(
        private readonly FeedbackRepositoryInterface                $feedbackRepository,
        private readonly SubmissionRepositoryInterface              $submissionRepository,
        private readonly AiFeedbackAnalyzerInterface                $aiFeedbackAnalyzer,
        private readonly FeedbackAnalysisResultPersisterInterface   $resultPersister,
        private readonly ConfigurationServiceInterface              $configurationService,
        private readonly GptTranslationServiceInterface             $translationService,
    ) {
        parent::__construct(self::COMMAND_NAME);
    }

    /**
     * {@inheritDoc}
     */
    protected function configure(): void
    {
        $this->setDescription(
            $this->translationService->translate(
                'command.aiFeedbackAnalysis.description',
                'de',          // default language key
                null           // let service apply project-wide fallback chain (EN, FR, ES, SW, EASY)
            )
        );
    }

    /**
     * Executes the analysis routine.
     *
     * @throws \Throwable On unexpected processing errors (caught by TYPO3 CLI dispatcher).
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->configurationService->isFeatureEnabled('gpt_feedback_analysis')) {
            $output->writeln(
                $this->translationService->translate('command.aiFeedbackAnalysis.disabled')
            );

            return self::SUCCESS;
        }

        $feedbackItems    = $this->feedbackRepository->findPendingForWeeklyAnalysis();
        $submissionItems  = $this->submissionRepository->findPendingForWeeklyAnalysis();
        $processedCounter = 0;

        foreach ($feedbackItems as $feedback) {
            $analysis = $this->aiFeedbackAnalyzer->analyzeFeedback($feedback);
            $this->resultPersister->persistFeedbackAnalysis($feedback, $analysis);
            ++$processedCounter;
        }

        foreach ($submissionItems as $submission) {
            $analysis = $this->aiFeedbackAnalyzer->analyzeSubmission($submission);
            $this->resultPersister->persistSubmissionAnalysis($submission, $analysis);
            ++$processedCounter;
        }

        $output->writeln(
            $this->translationService->translate(
                'command.aiFeedbackAnalysis.processed',
                null,
                ['{count}' => (string)$processedCounter]
            )
        );

        return self::SUCCESS;
    }
}
// EOF
