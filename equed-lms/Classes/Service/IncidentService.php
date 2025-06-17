<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\IncidentReport;
use Equed\EquedLms\Domain\Repository\IncidentReportRepositoryInterface;
use Equed\EquedLms\Factory\IncidentReportFactoryInterface;

/**
 * Service to manage QMS incident reports.
 */
final class IncidentService implements IncidentServiceInterface
{
    public function __construct(
        private readonly IncidentReportRepositoryInterface  $incidentReportRepository,
        private readonly IncidentReportFactoryInterface     $incidentReportFactory
    ) {
    }

    /**
     * Retrieve all open incident reports.
     *
     * @return IncidentReport[]
     */
    public function getOpenIncidents(): array
    {
        return $this->incidentReportRepository->findOpenCases();
    }

    /**
     * Count all incident reports for a specific frontend user.
     *
     * @param int $feUserId Frontend user UID
     * @return int
     */
    public function countIncidentsForUser(int $feUserId): int
    {
        $incidents = $this->incidentReportRepository->findByFeUser($feUserId);

        return is_countable($incidents) ? count($incidents) : 0;
    }

    /**
     * Retrieve all escalated incident reports.
     *
     * @return IncidentReport[]
     */
    public function getEscalatedCases(): array
    {
        return $this->incidentReportRepository->findEscalatedCases();
    }

    /**
     * Create and persist a new incident report.
     *
     * @param int    $feUserId         Frontend user UID
     * @param int    $courseInstanceId CourseInstance UID
     * @param string $issue            Description of the issue
     * @return IncidentReport
     */
    public function createIncident(int $feUserId, int $courseInstanceId, string $issue): IncidentReport
    {
        $incident = $this->incidentReportFactory->create($feUserId, $courseInstanceId, $issue);

        $this->incidentReportRepository->add($incident);

        return $incident;
    }
}
