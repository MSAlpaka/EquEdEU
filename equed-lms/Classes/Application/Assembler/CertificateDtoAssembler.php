<?php

declare(strict_types=1);

namespace Equed\EquedLms\Application\Assembler;

use Equed\EquedLms\Domain\Model\Certificate;

final class CertificateDtoAssembler
{
    /**
     * @return array<string,mixed>
     */
    public static function fromEntity(Certificate $certificate): array
    {
        return [
            'id' => $certificate->getUid(),
            'title' => $certificate->getCourseInstance()->getCourseProgram()->getTitle(),
            'issuedAt' => $certificate->getIssuedAt()->format(DATE_ATOM),
            'validUntil' => $certificate->getValidUntil()?->format(DATE_ATOM),
            'code' => $certificate->getCertificateCode(),
            'publicUrl' => $certificate->getPublicUrl(),
            'downloadUrl' => '/api/certificate/download?certificateId=' . $certificate->getUid(),
            'badgeUrl' => '/api/certificate/badge?certificateId=' . $certificate->getUid(),
        ];
    }

    /**
     * @param iterable<Certificate> $certificates
     * @return array<int,array<string,mixed>>
     */
    public static function fromEntities(iterable $certificates): array
    {
        $data = [];
        foreach ($certificates as $certificate) {
            $data[] = self::fromEntity($certificate);
        }

        return $data;
    }
}
