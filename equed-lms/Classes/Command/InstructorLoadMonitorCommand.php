<?php

declare(strict_types=1);

namespace Equed\EquedLms\Command;

use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\InstructorLoadMonitorServiceInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Monitors instructor workload for improved course assignment.
 *
 * All human-readable strings are translated via {@see GptTranslationServiceInterface}
 * to support hybrid live-translation with fallback logic (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <instructor_load_monitor> feature toggle.
 */
#[AsCommand(
    name: InstructorLoadMonitorCommand::COMMAND_NAME,
    description: 'command.instructorLoadMonitor.description'
)]
final class InstructorLoadMonitorCommand extends Command
{
    public const COMMAND_NAME = 'equed:instructor:monitor';

    public function __construct(
        private readonly InstructorLoadMonitorServiceInterface $monitorService,
        private readonly ConfigurationServiceInterface        $configurationService,
        private readonly GptTranslationServiceInterface       $translationService,
    ) {
        parent::__construct(self::COMMAND_NAME);
    }

    protected function configure(): void
    {
        $this->setDescription(
            $this->translationService->translate(
                'command.instructorLoadMonitor.description',
                null,
                []
            )
        );
    }

    /**
     * Executes the instructor workload monitoring routine.
     *
     * @throws \Throwable Propagates unexpected domain exceptions.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->configurationService->isFeatureEnabled('instructor_load_monitor')) {
            $output->writeln(
                $this->translationService->translate('command.instructorLoadMonitor.disabled')
            );

            return self::SUCCESS;
        }

        $monitoredCount = $this->monitorService->monitorLoads();

        $output->writeln(
            $this->translationService->translate(
                'command.instructorLoadMonitor.processed',
                null,
                ['{count}' => (string) $monitoredCount]
            )
        );

        return self::SUCCESS;
    }
}
// EOF
