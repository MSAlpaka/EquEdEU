<?php

declare(strict_types=1);

namespace Equed\EquedLms\Command;

use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\AppSyncServiceInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * CLI command that synchronizes learning progress with the mobile app.
 *
 * All human-readable strings are translated via {@see GptTranslationServiceInterface}
 * using the project-wide fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <app_sync> feature toggle.
 */
#[AsCommand(
    name: SyncAppCommand::COMMAND_NAME,
    description: 'command.appSync.description'
)]
final class SyncAppCommand extends Command
{
    public const COMMAND_NAME = 'equed:app:sync';

    public function __construct(
        private readonly AppSyncServiceInterface          $appSyncService,
        private readonly ConfigurationServiceInterface    $configurationService,
        private readonly GptTranslationServiceInterface   $translationService,
    ) {
        parent::__construct(self::COMMAND_NAME);
    }

    protected function configure(): void
    {
        $this->setDescription(
            $this->translationService->translate('command.appSync.description')
        );
    }

    /**
     * Executes the app synchronization routine.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return int
     * @throws \Throwable Propagates unexpected domain exceptions.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->configurationService->isFeatureEnabled('app_sync')) {
            $output->writeln(
                $this->translationService->translate('command.appSync.disabled')
            );

            return self::SUCCESS;
        }

        $this->appSyncService->sync();

        $output->writeln(
            $this->translationService->translate('command.appSync.processed')
        );

        return self::SUCCESS;
    }
}
// End of file
