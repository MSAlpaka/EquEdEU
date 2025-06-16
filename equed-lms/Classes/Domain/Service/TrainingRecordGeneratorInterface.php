<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Service;

use Equed\EquedLms\Domain\Model\UserCourseRecord;

interface TrainingRecordGeneratorInterface
{
    /**
     * Builds the certificate data array from a course record.
     *
     * @param UserCourseRecord $record
     * @return array{course:string,cert_number:string,issued_on:string}
     */
    public function createCertificateData(UserCourseRecord $record): array;

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
