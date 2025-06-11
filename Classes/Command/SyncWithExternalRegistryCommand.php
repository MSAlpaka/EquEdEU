<?php

declare(strict_types=1);

namespace Equed\EquedLms\Command;

use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\ExternalRegistrySyncServiceInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: SyncWithExternalRegistryCommand::COMMAND_NAME,
    description: 'command.syncWithExternalRegistry.description'
)]
final class SyncWithExternalRegistryCommand extends Command
{
    public const COMMAND_NAME = 'equed:sync:registry';

    public function __construct(
        private readonly ExternalRegistrySyncServiceInterface $syncService,
        private readonly ConfigurationServiceInterface        $configurationService,
        private readonly GptTranslationServiceInterface       $translationService,
    ) {
        parent::__construct(self::COMMAND_NAME);
    }

    protected function configure(): void
    {
        $this->setDescription(
            $this->translationService->translate(
                'command.syncWithExternalRegistry.description'
            )
        );
    }

    /**
     * Executes the synchronization routine with the external registry.
     *
     * @throws \Throwable Propagates unexpected domain exceptions.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->configurationService->isFeatureEnabled('sync_with_external_registry')) {
            $output->writeln(
                $this->translationService->translate(
                    'command.syncWithExternalRegistry.disabled'
                )
            );

            return self::SUCCESS;
        }

        $syncedCount = $this->syncService->sync();

        $output->writeln(
            $this->translationService->translate(
                'command.syncWithExternalRegistry.processed',
                null,
                ['{count}' => (string) $syncedCount]
            )
        );

        return self::SUCCESS;
    }
}
// EOF
