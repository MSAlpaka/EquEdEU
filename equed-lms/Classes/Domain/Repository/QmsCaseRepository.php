<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\QmsCase;
use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository for QMS cases.
 *
 * @extends Repository<QmsCase>
 */
final class QmsCaseRepository extends Repository
{
    protected array $defaultOrderings = [
        'createdAt' => QueryInterface::ORDER_DESCENDING,
    ];

    /**
     * Finds all open QMS cases.
     *
     * @return QmsCase[]
     */
    public function findOpenCases(): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('status', 'open')
        );

        return $query->execute()->toArray();
    }

    /**
     * Finds all QMS cases for a given instructor.
     *
     * @param FrontendUser $instructor
     * @return QmsCase[]
     */
    public function findByInstructor(FrontendUser $instructor): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('instructor', $instructor)
        );

        return $query->execute()->toArray();
    }

    /**
     * Finds all escalated QMS cases.
     *
     * @return QmsCase[]
     */
    public function findEscalatedCases(): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('escalated', true)
        );

        return $query->execute()->toArray();
    }

    /**
     * Finds all QMS cases for a given instructor.
     *
     * @param FrontendUser $user
     * @return QmsCase[]
     */
    public function findByUser(FrontendUser $user): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('instructor', $user)
        );

        return $query->execute()->toArray();
    }
}
// EOF
