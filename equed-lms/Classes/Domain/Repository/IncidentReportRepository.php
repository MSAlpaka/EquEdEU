<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\IncidentReport;
use Equed\EquedLms\Domain\Model\CourseInstance;
use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository for IncidentReport entities.
 */
class IncidentReportRepository extends Repository
{
    /**
     * Finds all incident reports for a specific frontend user.
     *
     * @param FrontendUser $user
     * @return IncidentReport[]
     */
    public function findByFeUser(FrontendUser $user): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('feUser', $user)
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
    public function findByStatus(string $status): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('status', $status)
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
// EOF
