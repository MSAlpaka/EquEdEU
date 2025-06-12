<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Closure;
use TCPDF;
use ZipArchive;
use RuntimeException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Equed\EquedLms\Domain\Service\TrainingRecordGeneratorInterface;

/**
 * Service for generating training record documents (PDF and ZIP).
 */
final class TrainingRecordGeneratorService implements TrainingRecordGeneratorInterface
{
    private readonly string $outputDirectory;
    private readonly Filesystem $filesystem;
    /** @var callable(): TCPDF */
    private readonly \Closure $pdfFactory;
    /** @var callable(): ZipArchive */
    private readonly \Closure $zipFactory;

    /**
     * @param string                $outputDirectory Absolute path for storing generated files
     * @param callable(): TCPDF|null       $pdfFactory   Factory for TCPDF instances
     * @param callable(): ZipArchive|null  $zipFactory   Factory for ZipArchive instances
     *
     * @throws RuntimeException If the output directory cannot be created
     */
    public function __construct(
        string $outputDirectory,
        ?Filesystem $filesystem = null,
        ?callable $pdfFactory = null,
        ?callable $zipFactory = null
    ) {
        $this->outputDirectory = rtrim($outputDirectory, '/');
        $this->filesystem = $filesystem ?? new Filesystem();
        $this->pdfFactory = $pdfFactory !== null
            ? Closure::fromCallable($pdfFactory)
            : static fn (): TCPDF => new TCPDF();
        $this->zipFactory = $zipFactory !== null
            ? Closure::fromCallable($zipFactory)
            : static fn (): ZipArchive => new ZipArchive();
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
            throw new RuntimeException(
                sprintf('Unable to create output directory "%s".', $this->outputDirectory),
                0,
                $e
            );
        }
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
            throw new RuntimeException(
                sprintf('Unable to create ZIP file "%s".', $zipFilePath)
            );
        }

        $pdfPath = $this->generatePdf($certificateData);
        $zip->addFile($pdfPath, basename($pdfPath));
        $zip->close();

        return $zipFilePath;
    }
}
