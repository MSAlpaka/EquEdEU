<?php

declare(strict_types=1);

namespace Equed\EquedLms\Command;

use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\NotificationQueueDispatcherInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * CLI command that dispatches all pending notification-queue entries
 * (e-mail, push, in-app) in a single, atomic run.
 *
 * Project-specific compliance:
 *  – Human-readable output is translated via {@see GptTranslationServiceInterface}
 *    to support the hybrid live-translation feature (EN → DE → FR → ES → SW → EASY).
 *  – Execution is guarded by the <notification_dispatch> feature toggle.
 *  – Business logic is delegated to a domain service; no persistence leakage.
 *  – Contains zero raw SQL, debug output, or dead code.
 */
#[AsCommand(
    name: DispatchNotificationQueueCommand::COMMAND_NAME,
    description: 'Dispatches all pending notifications in the queue.'
)]
final class DispatchNotificationQueueCommand extends Command
{
    public const COMMAND_NAME = 'equed:notification:dispatch';

    public function __construct(
        private readonly NotificationQueueDispatcherInterface $dispatcher,
        private readonly ConfigurationServiceInterface        $configurationService,
        private readonly GptTranslationServiceInterface       $translationService,
    ) {
        parent::__construct(self::COMMAND_NAME);
    }

    protected function configure(): void
    {
        $this->setDescription(
            $this->translationService->translate('command.notificationDispatch.description')
        );
    }

    /**
     * Executes the notification-dispatch routine.
     *
     * @throws \Throwable Propagates unexpected domain exceptions.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->configurationService->isFeatureEnabled('notification_dispatch')) {
            $output->writeln(
                $this->translationService->translate('command.notificationDispatch.disabled')
            );

            return self::SUCCESS;
        }

        $dispatchedCount = $this->dispatcher->dispatchAllPending();

        $output->writeln(
            $this->translationService->translate(
                'command.notificationDispatch.processed',
                null,
                ['{count}' => (string) $dispatchedCount],
            )
        );

        return self::SUCCESS;
    }
}
// EOF
