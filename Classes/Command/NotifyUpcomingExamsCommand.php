<?php

declare(strict_types=1);

namespace Equed\EquedLms\Command;

use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\ExamNotificationServiceInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * CLI command to notify users about upcoming exams.
 *
 * All human-readable strings are translated via {@see GptTranslationServiceInterface}
 * to leverage the hybrid live-translation service with fallback chain
 * (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <notify_upcoming_exams> feature toggle.
 */
#[AsCommand(
    name: NotifyUpcomingExamsCommand::COMMAND_NAME,
    description: 'Notifies users about upcoming exams.'
)]
final class NotifyUpcomingExamsCommand extends Command
{
    public const COMMAND_NAME = 'equed:exam:notify-upcoming';

    public function __construct(
        private readonly ExamNotificationServiceInterface $notificationService,
        private readonly ConfigurationServiceInterface     $configurationService,
        private readonly GptTranslationServiceInterface    $translationService,
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
                'command.notifyUpcomingExams.description',
                null,
                []
            )
        );
    }

    /**
     * Executes the notification routine for upcoming exams.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return int
     * @throws \Throwable Propagates unexpected domain exceptions.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->configurationService->isFeatureEnabled('notify_upcoming_exams')) {
            $output->writeln(
                $this->translationService->translate('command.notifyUpcomingExams.disabled')
            );

            return self::SUCCESS;
        }

        $count = $this->notificationService->notifyAll();
        $output->writeln(
            $this->translationService->translate(
                'command.notifyUpcomingExams.processed',
                null,
                ['{count}' => (string)$count],
            )
        );

        return self::SUCCESS;
    }
}
// End of file
