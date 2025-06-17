<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\IncidentReport;

interface IncidentServiceInterface
{
    /**
     * @return IncidentReport[]
     */
    public function getOpenIncidents(): array;

    public function countIncidentsForUser(int $feUserId): int;

    /**
     * @return IncidentReport[]
     */
    public function getEscalatedCases(): array;

    public function createIncident(int $feUserId, int $courseInstanceId, string $issue): IncidentReport;
}
