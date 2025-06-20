<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\CertificateDispatch;
use Equed\EquedLms\Domain\Model\CourseInstance;
use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Persistence\Repository;
use Equed\EquedLms\Domain\Repository\CertificateDispatchRepositoryInterface;

/**
 * Repository for CertificateDispatch entities.

 *
 * @extends Repository<CertificateDispatch>
 */
final class CertificateDispatchRepository extends Repository implements CertificateDispatchRepositoryInterface
{
    /**
     * Finds all dispatched certificates for a specific instructor.
     *
     * @param FrontendUser $frontendUser
     * @return CertificateDispatch[]
     */
    public function findByFeUser(FrontendUser $frontendUser): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('instructor', $frontendUser)
        );

        return $query->execute()->toArray();
    }

    /**
     * Finds all dispatched certificates for a specific course instance.
     *
     * @param CourseInstance $courseInstance
     * @return CertificateDispatch[]
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
     * Finds all pending certificate dispatches (no PDF generated or QR code missing).
     *
     * @return CertificateDispatch[]
     */
    public function findPending(): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalOr([
                $query->equals('pdf', null),
                $query->equals('qrCodeUrl', ''),
            ])
        );

        return $query->execute()->toArray();
    }

    /**
     * Adds a new certificate dispatch to the repository.
     *
     * @param CertificateDispatch $dispatch The certificate dispatch instance to add.
     * @return void
     */
    public function add(CertificateDispatch $dispatch): void
    {
        parent::add($dispatch);
    }
}
