<?php

declare(strict_types=1);

namespace Equed\EquedLms\Command;

use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\BadgeCalculationServiceInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * CLI command that (re-)calculates achievement badges for all
 * {@see \Equed\EquedLms\Domain\Model\UserCourseRecord} entities.
 *
 * The command adheres to all EEE HoofCare requirements:
 *  – Human-readable output is translated via {@see GptTranslationServiceInterface}
 *  – Execution is guarded by the <badge_calculation> feature toggle
 *  – Interacts solely with a domain service; no persistence leakage
 *  – Contains zero raw SQL, debug output, or dead code
 */
#[AsCommand(
    name: CalculateBadgeCommand::COMMAND_NAME,
    description: 'Recalculates user achievement badges.'
)]
final class CalculateBadgeCommand extends Command
{
    public const COMMAND_NAME = 'equed:badge:calculate';

    public function __construct(
        private readonly BadgeCalculationServiceInterface $badgeCalculationService,
        private readonly ConfigurationServiceInterface    $configurationService,
        private readonly GptTranslationServiceInterface   $translationService,
    ) {
        parent::__construct(self::COMMAND_NAME);
    }

    protected function configure(): void
    {
        $this->setDescription(
            $this->translationService->translate('command.badgeCalculation.description')
        );
    }

    /**
     * Executes the badge-calculation routine.
     *
     * @throws \Throwable Propagates unexpected domain exceptions.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->configurationService->isFeatureEnabled('badge_calculation')) {
            $output->writeln(
                $this->translationService->translate('command.badgeCalculation.disabled')
            );

            return self::SUCCESS;
        }

        $calculatedCount = $this->badgeCalculationService->recalculateBadges();

        $output->writeln(
            $this->translationService->translate(
                'command.badgeCalculation.processed',
                null,
                ['{count}' => (string) $calculatedCount],
            )
        );

        return self::SUCCESS;
    }
}
// End of file
