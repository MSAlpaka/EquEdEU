<?php

declare(strict_types=1);

namespace Equed\EquedLms\Dto;

/**
 * Structured dashboard data for Service Centers.
 */
final class ServiceCenterDashboardData implements \JsonSerializable
{
    /**
     * @param array<int,array<string,mixed>> $certificates
     * @param array<int,array<string,mixed>> $submissions
     * @param array<int,array<string,mixed>> $qmsCases
     */
    public function __construct(
        private readonly int $centerId,
        private readonly array $certificates = [],
        private readonly array $submissions = [],
        private readonly array $qmsCases = [],
    ) {
    }

    public function getCenterId(): int
    {
        return $this->centerId;
    }

    /** @return array<int,array<string,mixed>> */
    public function getCertificates(): array
    {
        return $this->certificates;
    }

    /** @return array<int,array<string,mixed>> */
    public function getSubmissions(): array
    {
        return $this->submissions;
    }

    /** @return array<int,array<string,mixed>> */
    public function getQmsCases(): array
    {
        return $this->qmsCases;
    }

    public function jsonSerialize(): array
    {
        return [
            'centerId'     => $this->centerId,
            'certificates' => $this->certificates,
            'submissions'  => $this->submissions,
            'qmsCases'     => $this->qmsCases,
        ];
    }
}
