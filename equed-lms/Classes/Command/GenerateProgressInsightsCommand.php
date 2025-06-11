<?php

declare(strict_types=1);

namespace Equed\EquedLms\Command;

use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\ProgressInsightsServiceInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * CLI command that generates progress insights from user course data.
 *
 * Human-readable output is translated via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 *
 * Feature toggle: <progress_insights> (config.yaml)
 */
#[AsCommand(
    name: GenerateProgressInsightsCommand::COMMAND_NAME,
    description: 'command.progressInsights.description'
)]
final class GenerateProgressInsightsCommand extends Command
{
    public const COMMAND_NAME = 'equed:insight:progress';

    public function __construct(
        private readonly ProgressInsightsServiceInterface $insightsService,
        private readonly ConfigurationServiceInterface    $configurationService,
        private readonly GptTranslationServiceInterface   $translationService,
    ) {
        parent::__construct(self::COMMAND_NAME);
    }

    protected function configure(): void
    {
        $this->setDescription(
            $this->translationService->translate(
                'command.progressInsights.description',
                null,
                []
            )
        );
    }

    /**
     * Executes the progress-insights generation routine.
     *
     * @throws \Throwable Propagates unexpected domain exceptions.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->configurationService->isFeatureEnabled('progress_insights')) {
            $output->writeln(
                $this->translationService->translate('command.progressInsights.disabled')
            );

            return self::SUCCESS;
        }

        $generatedCount = $this->insightsService->generateProgressInsights();

        $output->writeln(
            $this->translationService->translate(
                'command.progressInsights.processed',
                null,
                ['{count}' => (string) $generatedCount]
            )
        );

        return self::SUCCESS;
    }
}
// EOF
