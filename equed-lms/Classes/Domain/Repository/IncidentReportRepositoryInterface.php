<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\CourseInstance;
use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Domain\Model\IncidentReport;
use Equed\EquedLms\Enum\IncidentReportStatus;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

interface IncidentReportRepositoryInterface
{
    /**
     * @param FrontendUser $user
     * @return IncidentReport[]
     */
    public function findByFeUser(FrontendUser $user): array;

    /**
     * @param CourseInstance $courseInstance
     * @return IncidentReport[]
     */
    public function findByCourseInstance(CourseInstance $courseInstance): array;

    /**
     * @return IncidentReport[]
     */
    public function findOpenCases(): array;

    /**
     * @param IncidentReportStatus|string $status
     * @return IncidentReport[]
     */
    public function findByStatus(IncidentReportStatus|string $status): array;

    /**
     * @param int $uid
     * @return IncidentReport|null
     */
    public function findByUid(int $uid): ?IncidentReport;

    /**
     * @return QueryInterface<IncidentReport>
     */
    public function createQuery(): QueryInterface;
}

