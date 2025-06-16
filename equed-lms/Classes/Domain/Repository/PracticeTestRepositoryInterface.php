<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\PracticeTest;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

interface PracticeTestRepositoryInterface
{
    /**
     * @return PracticeTest[]
     */
    public function findAllActive(): array;

    /**
     * @param int $uid
     * @return PracticeTest|null
     */
    public function findByUid(int $uid): ?PracticeTest;

    /**
     * @return QueryInterface<PracticeTest>
     */
    public function createQuery(): QueryInterface;
}

