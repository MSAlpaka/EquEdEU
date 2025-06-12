<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\PracticeTest;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository for PracticeTest entities.
 */
final class PracticeTestRepository extends Repository
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
// EOF
