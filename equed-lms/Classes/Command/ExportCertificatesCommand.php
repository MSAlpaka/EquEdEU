<?php

declare(strict_types=1);

namespace Equed\EquedLms\Command;

use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\CertificateExportServiceInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * CLI command that exports all newly issued certificates as a single PDF bundle
 * and marks them as “sent”. Human-readable output strings are translated via
 * {@see GptTranslationServiceInterface} to support the project’s hybrid live-
 * translation feature with automatic fallback logic.
 *
 * Feature toggle: <certificate_export> (config.yaml)
 */
#[AsCommand(
    name: ExportCertificatesCommand::COMMAND_NAME,
    description: 'Exports newly issued certificates as PDF.'
)]
final class ExportCertificatesCommand extends Command
{
    public const COMMAND_NAME = 'equed:cert:export';

    public function __construct(
        private readonly CertificateExportServiceInterface $exportService,
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
            $this->translationService->translate('command.certificateExport.description')
        );
    }

    /**
     * Executes the certificate-export routine.
     *
     * @throws \Throwable If the domain service encounters an unrecoverable error.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->configurationService->isFeatureEnabled('certificate_export')) {
            $output->writeln(
                $this->translationService->translate('command.certificateExport.disabled')
            );

            return self::SUCCESS;
        }

        $filePath = $this->exportService->exportUnsentCertificates();

        $output->writeln(
            $this->translationService->translate(
                'command.certificateExport.processed',
                null,
                ['{file}' => $filePath],
            )
        );

        return self::SUCCESS;
    }
}
// EOF
