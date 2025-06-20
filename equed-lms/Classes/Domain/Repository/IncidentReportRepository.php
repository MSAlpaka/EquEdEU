<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\IncidentReport;
use Equed\EquedLms\Domain\Model\CourseInstance;
use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Persistence\Repository;
use Equed\EquedLms\Enum\IncidentReportStatus;
use Equed\EquedLms\Domain\Repository\IncidentReportRepositoryInterface;

/**
 * Repository for IncidentReport entities.

 *
 * @extends Repository<IncidentReport>
 */
final class IncidentReportRepository extends Repository implements IncidentReportRepositoryInterface
{
    /**
     * Finds all incident reports for a specific instructor.
     *
     * @param FrontendUser $user
     * @return IncidentReport[]
     */
    public function findByFeUser(FrontendUser $user): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('instructor', $user)
        );

        return $query->execute()->toArray();
    }

    /**
     * Finds all incident reports for a specific course instance.
     *
     * @param CourseInstance $courseInstance
     * @return IncidentReport[]
     */
    public function findByCourseInstance(CourseInstance $courseInstance): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('courseInstance', $courseInstance)
        );

        return $query->execute()->toArray();
    }

    /**
     * Finds all open or unresolved incident reports.
     *
     * @return IncidentReport[]
     */
    public function findOpenCases(): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalNot(
                $query->equals('status', 'resolved')
            )
        );

        return $query->execute()->toArray();
    }

    /**
     * Finds all incident reports with a specific status.
     *
     * @param string $status
     * @return IncidentReport[]
     */
    public function findByStatus(IncidentReportStatus|string $status): array
    {
        if (is_string($status)) {
            $status = IncidentReportStatus::from($status);
        }
        $query = $this->createQuery();
        $query->matching(
            $query->equals('status', $status->value)
        );

        return $query->execute()->toArray();
    }

    /**
     * Find an incident report by UID.
     *
     * @param int $uid
     * @return IncidentReport|null
     */
    public function findByUid(int $uid): ?IncidentReport
    {
        return $this->findByIdentifier($uid);
    }
}
