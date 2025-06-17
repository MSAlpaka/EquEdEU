<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Closure;
use TCPDF;
use ZipArchive;
use RuntimeException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Equed\EquedLms\Service\LogService;
use Equed\EquedLms\Domain\Service\LanguageServiceInterface;
use Equed\EquedLms\Service\TranslatedLoggerTrait;
use Equed\EquedLms\Domain\Service\TrainingRecordGeneratorInterface;
use Equed\EquedLms\Domain\Model\UserCourseRecord;

/**
 * Service for generating training record documents (PDF and ZIP).
 */
final class TrainingRecordGeneratorService implements TrainingRecordGeneratorInterface
{
    use TranslatedLoggerTrait;
    private readonly string $outputDirectory;
    private readonly Filesystem $filesystem;
    /** @var callable(): TCPDF */
    private readonly \Closure $pdfFactory;
    /** @var callable(): ZipArchive */
    private readonly \Closure $zipFactory;

    /**
     * @param string               $outputDirectory Absolute path for storing generated files
     * @param callable(): TCPDF    $pdfFactory      Factory for TCPDF instances
     * @param callable(): ZipArchive $zipFactory     Factory for ZipArchive instances
     *
     * @throws RuntimeException If the output directory cannot be created
     */
    public function __construct(
        string $outputDirectory,
        LanguageServiceInterface $translationService,
        LogService $logService,
        Filesystem $filesystem,
        callable $pdfFactory,
        callable $zipFactory
    ) {
        $this->outputDirectory = rtrim($outputDirectory, '/');
        $this->filesystem = $filesystem;
        $this->pdfFactory = Closure::fromCallable($pdfFactory);
        $this->zipFactory = Closure::fromCallable($zipFactory);
        $this->injectTranslatedLogger($translationService, $logService);
    }

    /**
     * Ensures that the output directory exists.
     *
     * @throws RuntimeException If the directory cannot be created
     */
    private function ensureOutputDirectory(): void
    {
        if ($this->filesystem->exists($this->outputDirectory)) {
            return;
        }

        try {
            $this->filesystem->mkdir($this->outputDirectory, 0775);
        } catch (IOExceptionInterface $e) {
            $this->logTranslatedError('trainingRecord.dir.createFailed', ['dir' => $this->outputDirectory]);
            throw new RuntimeException(
                sprintf('Unable to create output directory "%s".', $this->outputDirectory),
                0,
                $e
            );
        }
    }

    /**
     * Collects certificate data from a user course record.
     *
     * @param UserCourseRecord $record
     * @return array{course:string,cert_number:string,issued_on:string}
     */
    public function createCertificateData(UserCourseRecord $record): array
    {
        $program = $record->getCourseInstance()->getCourseProgram();

        return [
            'cert_number' => $record->getCertificateNumber(),
            'course'      => $program?->getTitle() ?? '',
            'issued_on'   => $record->getCompletionDate()?->format('Y-m-d') ?? '',
        ];
    }

    /**
     * Generates a PDF certificate document.
     *
     * @param array{course:string,cert_number:string,issued_on:string} $certificateData
     * @return string Absolute path to the generated PDF file
     * @throws RuntimeException On failure to write PDF
     */
    public function generatePdf(array $certificateData): string
    {
        $this->ensureOutputDirectory();

        $fileKey = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $certificateData['cert_number']);
        $filePath = $this->outputDirectory . '/' . $fileKey . '.pdf';

        $pdf = ($this->pdfFactory)();
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Write(0, 'Certificate of Completion');
        $pdf->Ln();
        $pdf->Write(0, 'Course: ' . ($certificateData['course'] ?? ''));
        $pdf->Ln();
        $pdf->Write(0, 'Certificate Number: ' . $certificateData['cert_number']);
        $pdf->Ln();
        $pdf->Write(0, 'Issued On: ' . $certificateData['issued_on']);
        $pdf->Ln();

        $content = $pdf->Output('', 'S');
        try {
            $this->filesystem->dumpFile($filePath, $content);
        } catch (IOExceptionInterface $e) {
            $this->logTranslatedError('trainingRecord.pdf.writeFailed', ['file' => $filePath]);
            throw new RuntimeException(
                sprintf('Unable to write PDF file "%s".', $filePath),
                0,
                $e
            );
        }

        return $filePath;
    }

    /**
     * Generates a ZIP archive containing the PDF certificate.
     *
     * @param array{course:string,cert_number:string,issued_on:string} $certificateData
     * @return string Absolute path to the generated ZIP file
     * @throws RuntimeException On failure to create ZIP
     */
    public function generateZip(array $certificateData): string
    {
        $this->ensureOutputDirectory();

        $zip = ($this->zipFactory)();
        $fileKey = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $certificateData['cert_number']);
        $zipFilePath = $this->outputDirectory . '/' . $fileKey . '.zip';

        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            $this->logTranslatedError('trainingRecord.zip.createFailed', ['file' => $zipFilePath]);
            throw new RuntimeException(
                sprintf('Unable to create ZIP file "%s".', $zipFilePath)
            );
        }

        $pdfPath = $this->generatePdf($certificateData);
        $zip->addFile($pdfPath, basename($pdfPath));
        $zip->close();

        $this->filesystem->remove($pdfPath);

        return $zipFilePath;
    }
}
