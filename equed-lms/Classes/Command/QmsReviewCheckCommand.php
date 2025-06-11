<?php

declare(strict_types=1);

namespace Equed\EquedLms\Command;

use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\QmsReviewServiceInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * CLI command that checks for overdue QMS reviews and triggers escalations.
 *
 * Human-readable output is translated via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <qms_review_check> feature toggle.
 */
#[AsCommand(
    name: QmsReviewCheckCommand::COMMAND_NAME,
    description: 'command.qmsReviewCheck.description'
)]
final class QmsReviewCheckCommand extends Command
{
    public const COMMAND_NAME = 'equed:qms:review-check';

    public function __construct(
        private readonly QmsReviewServiceInterface      $reviewService,
        private readonly ConfigurationServiceInterface  $configurationService,
        private readonly GptTranslationServiceInterface $translationService,
    ) {
        parent::__construct(self::COMMAND_NAME);
    }

    protected function configure(): void
    {
        $this->setDescription(
            $this->translationService->translate('command.qmsReviewCheck.description')
        );
    }

    /**
     * Executes the review process for overdue QMS cases.
     *
     * @throws \Throwable Propagates unexpected domain exceptions.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->configurationService->isFeatureEnabled('qms_review_check')) {
            $output->writeln(
                $this->translationService->translate('command.qmsReviewCheck.disabled')
            );

            return self::SUCCESS;
        }

        $overdueCount = $this->reviewService->processOverdue();
        $output->writeln(
            $this->translationService->translate(
                'command.qmsReviewCheck.processed',
                null,
                ['{count}' => (string) $overdueCount]
            )
        );

        return self::SUCCESS;
    }
}
// EOF
