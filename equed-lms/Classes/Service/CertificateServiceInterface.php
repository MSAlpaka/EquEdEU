<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

/**
 * Hier deine Beschreibung…
 */
use Equed\EquedLms\Domain\Model\CertificateDispatch;
use Equed\EquedLms\Domain\Model\UserCourseRecord;

interface CertificateServiceInterface
{
    /**
     * @param array<string, mixed> $data
     */
    public function processCertificate(array $data): bool;

    public function issueCertificate(UserCourseRecord $userCourseRecord): CertificateDispatch;

    public function sendCertificateNotification(CertificateDispatch $dispatch): void;

    public function getCertificateFilePath(int $certificateId, int $userId): ?string;

    public function getCertificateDownloadUrl(string $filePath): string;

    public function processDispatchQueue(): void;
}
