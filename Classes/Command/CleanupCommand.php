<?php

declare(strict_types=1);

namespace Equed\EquedLms\Command;

use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;

/**
 * Removes outdated audit-log entries in accordance with the project’s
 * data-retention policy and feature toggles.
 *
 * Configuration keys
 * ------------------
 * audit_log_cleanup          bool   Enables/disables the cleanup entirely.
 * audit_log_retention_days   int    Retain logs for N days (default 180).
 *
 * All human-readable output is routed through {@see GptTranslationServiceInterface}
 * to leverage the hybrid live-translation service with fallback handling.
 */
#[AsCommand(
    name: CleanupCommand::COMMAND_NAME,
    description: 'Cleans up outdated audit-log entries.',
)]
final class CleanupCommand extends Command
{
    public const COMMAND_NAME = 'equed:db:cleanup';

    public function __construct(
        private readonly ConnectionPool                 $connectionPool,
        private readonly ConfigurationServiceInterface  $configurationService,
        private readonly GptTranslationServiceInterface $translationService,
    ) {
        parent::__construct(self::COMMAND_NAME);
    }

    /**
     * {@inheritDoc}
     */
    protected function configure(): void
    {
        $this->setDescription(
            $this->translationService->translate('command.cleanup.description')
        );
    }

    /**
     * Executes the audit-log cleanup.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->configurationService->isFeatureEnabled('audit_log_cleanup')) {
            $output->writeln(
                $this->translationService->translate('command.cleanup.disabled')
            );

            return self::SUCCESS;
        }

        $retentionDays = $this->configurationService->getInt(
            'audit_log_retention_days',
            180 // default: 6 months
        );

        $cutoffTimestamp = (new \DateTimeImmutable())
            ->modify(sprintf('-%d days', $retentionDays))
            ->getTimestamp();

        /** @var QueryBuilder $qb */
        $qb = $this->connectionPool
            ->getConnectionForTable('tx_equedlms_domain_model_auditlog')
            ->createQueryBuilder();

        $deletedRows = $qb
            ->delete('tx_equedlms_domain_model_auditlog')
            ->where($qb->expr()->lt('crdate', ':cutoff'))
            ->setParameter(':cutoff', $cutoffTimestamp, \PDO::PARAM_INT)
            ->executeStatement();

        $output->writeln(
            $this->translationService->translate(
                'command.cleanup.processed',
                null,
                ['{count}' => (string) $deletedRows],
            )
        );

        return self::SUCCESS;
    }
}
// EOF
