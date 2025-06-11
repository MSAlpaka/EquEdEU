<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\CertificateDispatch;
use Equed\EquedLms\Domain\Model\CourseInstance;
use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

interface CertificateDispatchRepositoryInterface
{
    /**
     * @return CertificateDispatch[]
     */
    public function findByFeUser(FrontendUser $frontendUser): array;

    /**
     * @return CertificateDispatch[]
     */
    public function findByCourseInstance(CourseInstance $courseInstance): array;

    /**
     * @return CertificateDispatch[]
     */
    public function findPending(): array;

    /**
     * @param CertificateDispatch $dispatch
     */
    public function add(CertificateDispatch $dispatch): void;

    /**
     * @return QueryInterface<CertificateDispatch>
     */
    public function createQuery(): QueryInterface;
}
