<?php

declare(strict_types=1);

namespace Equed\EquedLms\Command;

use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Repository\CourseInstanceRepositoryInterface;
use Equed\EquedLms\Domain\Service\ExternalExaminerAssignmentStrategyInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * CLI command that automatically assigns an external examiner to every
 * {@see \Equed\EquedLms\Domain\Model\CourseInstance} that requires one
 * and is still missing an assignment.
 *
 * The command complies with all EEE HoofCare project rules:
 *  – Respects feature toggle <auto_assign_external_examiner>
 *  – All human-readable strings pass through the {@see GptTranslationServiceInterface}
 *    to leverage the hybrid live-translation service with fallback chain
 *    (EN → DE → FR → ES → SW → EASY).
 *  – Interacts with domain aggregates exclusively via repository and
 *    strategy interfaces – no persistence or business logic leakage.
 *  – Contains zero raw SQL, relies on domain-level collections to prevent
 *    N+1 queries inside the loop.
 */
#[AsCommand(
    name: AutoAssignExternalExaminerCommand::COMMAND_NAME,
    description: 'Automatically assigns external examiners where required.'
)]
final class AutoAssignExternalExaminerCommand extends Command
{
    public const COMMAND_NAME = 'equed:examiner:autoassign';

    public function __construct(
        private readonly CourseInstanceRepositoryInterface           $courseInstanceRepository,
        private readonly ExternalExaminerAssignmentStrategyInterface $assignmentStrategy,
        private readonly ConfigurationServiceInterface               $configurationService,
        private readonly GptTranslationServiceInterface              $translationService,
    ) {
        parent::__construct(self::COMMAND_NAME);
    }

    /**
     * {@inheritDoc}
     */
    protected function configure(): void
    {
        $this->setDescription(
            $this->translationService->translate('command.autoAssignExaminer.description')
        );
    }

    /**
     * Executes the examiner assignment routine.
     *
     * @throws \Throwable Any unexpected domain exception bubbles up to
     *                    TYPO3's CLI dispatcher for central error handling.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->configurationService->isFeatureEnabled('auto_assign_external_examiner')) {
            $output->writeln(
                $this->translationService->translate('command.autoAssignExaminer.disabled')
            );

            return self::SUCCESS;
        }

        // The repository guarantees that relations to CourseProgram and
        // UserCourseRecord are pre-fetched to avoid N+1 issues.
        $instancesRequiringExaminer = $this->courseInstanceRepository
            ->findAllRequiringExternalExaminer();

        $assignedCount = 0;

        foreach ($instancesRequiringExaminer as $courseInstance) {
            if ($this->assignmentStrategy->assignExternalExaminer($courseInstance)) {
                ++$assignedCount;
            }
        }

        $output->writeln(
            $this->translationService->translate(
                'command.autoAssignExaminer.processed',
                null,
                ['{count}' => (string) $assignedCount],
            )
        );

        return self::SUCCESS;
    }
}
// EOF
