<?php

declare(strict_types=1);

namespace Equed\EquedLms\Command;

use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\BundleSuggestionServiceInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * CLI command that creates personalised course-bundle suggestions.
 *
 * All human-readable output passes through {@see GptTranslationServiceInterface}
 * to support hybrid live translation with project-wide fallbacks.
 * Persistence and business logic are delegated to the injected domain service.
 */
#[AsCommand(
    name: BundleSuggestionCommand::COMMAND_NAME,
    description: 'Generates personalised course-bundle suggestions.'
)]
final class BundleSuggestionCommand extends Command
{
    public const COMMAND_NAME = 'equed:bundle:suggest';

    public function __construct(
        private readonly BundleSuggestionServiceInterface $bundleSuggestionService,
        private readonly ConfigurationServiceInterface    $configurationService,
        private readonly GptTranslationServiceInterface   $translationService,
    ) {
        parent::__construct(self::COMMAND_NAME);
    }

    protected function configure(): void
    {
        $this->setDescription(
            $this->translationService->translate('command.bundleSuggestion.description')
        );
    }

    /**
     * Executes the bundle-suggestion routine.
     *
     * @throws \Throwable Propagates unexpected domain exceptions.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->configurationService->isFeatureEnabled('bundle_suggestion')) {
            $output->writeln(
                $this->translationService->translate('command.bundleSuggestion.disabled')
            );

            return self::SUCCESS;
        }

        $suggestedCount = $this->bundleSuggestionService->generateSuggestions();

        $output->writeln(
            $this->translationService->translate(
                'command.bundleSuggestion.processed',
                null,
                ['{count}' => (string) $suggestedCount],
            )
        );

        return self::SUCCESS;
    }
}
// EOF
