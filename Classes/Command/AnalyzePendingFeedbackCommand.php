<?php

declare(strict_types=1);

namespace Equed\EquedLms\Command;

use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Repository\FeedbackRepositoryInterface;
use Equed\EquedLms\Domain\Service\AiFeedbackAnalyzerInterface;
use Equed\EquedLms\Domain\Service\FeedbackAnalysisResultPersisterInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * CLI command that runs the GPT-based analysis of all feedback entries
 * currently marked as “pending”. Results are persisted via the domain
 * persister to keep storage concerns separated from processing logic.
 *
 * All human-readable output is routed through {@see GptTranslationServiceInterface}
 * to support the project’s hybrid live-translation feature with automatic
 * fallback handling (EN → DE → FR → ES → SW → EASY).
 */
#[AsCommand(
    name: AnalyzePendingFeedbackCommand::COMMAND_NAME,
    description: 'Runs the GPT-based analysis of pending feedback entries.'
)]
final class AnalyzePendingFeedbackCommand extends Command
{
    public const COMMAND_NAME = 'equed:feedback:analyze';

    public function __construct(
        private readonly FeedbackRepositoryInterface             $feedbackRepository,
        private readonly AiFeedbackAnalyzerInterface             $aiFeedbackAnalyzer,
        private readonly FeedbackAnalysisResultPersisterInterface $resultPersister,
        private readonly ConfigurationServiceInterface           $configurationService,
        private readonly GptTranslationServiceInterface          $translationService,
    ) {
        parent::__construct(self::COMMAND_NAME);
    }

    /**
     * {@inheritDoc}
     */
    protected function configure(): void
    {
        $this->setDescription(
            $this->translationService->translate('command.feedbackAnalysis.description')
        );
    }

    /**
     * Executes the pending-feedback analysis run.
     *
     * @throws \Throwable Propagates unexpected domain exceptions to
     *                    TYPO3’s CLI dispatcher for centralized handling.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->configurationService->isFeatureEnabled('gpt_feedback_analysis')) {
            $output->writeln(
                $this->translationService->translate('command.feedbackAnalysis.disabled')
            );

            return self::SUCCESS;
        }

        $pendingFeedback = $this->feedbackRepository->findPendingForAnalysis();
        $processedCount  = 0;

        foreach ($pendingFeedback as $feedback) {
            $analysis = $this->aiFeedbackAnalyzer->analyzeFeedback($feedback);
            $this->resultPersister->persistFeedbackAnalysis($feedback, $analysis);
            ++$processedCount;
        }

        $output->writeln(
            $this->translationService->translate(
                'command.feedbackAnalysis.processed',
                null,
                ['{count}' => (string) $processedCount],
            )
        );

        return self::SUCCESS;
    }
}
// EOF
