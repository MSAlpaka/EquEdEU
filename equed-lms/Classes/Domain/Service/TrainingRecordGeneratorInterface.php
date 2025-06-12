<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Service;

interface TrainingRecordGeneratorInterface
{
    /**
     * Generates a PDF certificate document.
     *
     * @param array{course:string,cert_number:string,issued_on:string} $certificateData
     * @return string Absolute path to the generated PDF file
     */
    public function generatePdf(array $certificateData): string;

    /**
     * Generates a ZIP archive containing the PDF certificate.
     *
     * @param array{course:string,cert_number:string,issued_on:string} $certificateData
     * @return string Absolute path to the generated ZIP file
     */
    public function generateZip(array $certificateData): string;
}
