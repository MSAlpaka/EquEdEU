<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\PracticeTest;
use TYPO3\CMS\Extbase\Persistence\Repository;
use Equed\EquedLms\Domain\Repository\PracticeTestRepositoryInterface;

/**
 * Repository for PracticeTest entities.

 *
 * @extends Repository<PracticeTest>
 */
final class PracticeTestRepository extends Repository implements PracticeTestRepositoryInterface
{
    /**
     * Finds all active practice tests (not marked deleted).
     *
     * @return PracticeTest[]
     */
    public function findAllActive(): array
    {
        return $this->createQuery()
            ->execute()
            ->toArray();
    }

    /**
     * Find a practice test by UID.
     *
     * @param int $uid
     * @return PracticeTest|null
     */
    public function findByUid(int $uid): ?PracticeTest
    {
        return $this->findByIdentifier($uid);
    }
}
