<?php

declare(strict_types=1);

namespace Equed\EquedLms\Command;

use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\UnfinishedCourseCleanupServiceInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * CLI command that cleans up orphaned course enrollments without progress.
 *
 * All human-readable output is translated via {@see GptTranslationServiceInterface}
 * to support the hybrid live-translation feature with fallback logic
 * (EN → DE → FR → ES → SW → EASY). Execution is guarded by the
 * <unfinished_course_cleanup> feature toggle.
 */
#[AsCommand(
    name: UnfinishedCourseCleanupCommand::COMMAND_NAME,
    description: 'command.unfinishedCourseCleanup.description'
)]
final class UnfinishedCourseCleanupCommand extends Command
{
    public const COMMAND_NAME = 'equed:course:cleanup';

    public function __construct(
        private readonly UnfinishedCourseCleanupServiceInterface $cleanupService,
        private readonly ConfigurationServiceInterface           $configurationService,
        private readonly GptTranslationServiceInterface          $translationService,
    ) {
        parent::__construct(self::COMMAND_NAME);
    }

    protected function configure(): void
    {
        $this->setDescription(
            $this->translationService->translate('command.unfinishedCourseCleanup.description')
        );
    }

    /**
     * Executes the cleanup routine for orphaned course enrollments.
     *
     * @throws \Throwable Propagates unexpected domain exceptions.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->configurationService->isFeatureEnabled('unfinished_course_cleanup')) {
            $output->writeln(
                $this->translationService->translate('command.unfinishedCourseCleanup.disabled')
            );

            return self::SUCCESS;
        }

        $deletedCount = $this->cleanupService->cleanupOrphanedEnrollments();

        $output->writeln(
            $this->translationService->translate(
                'command.unfinishedCourseCleanup.processed',
                null,
                ['{count}' => (string) $deletedCount],
            )
        );

        return self::SUCCESS;
    }
}
// EOF
