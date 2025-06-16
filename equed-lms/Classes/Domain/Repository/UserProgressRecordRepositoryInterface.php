<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\UserProgressRecord;
use Equed\EquedLms\Enum\ProgressRecordStatus;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

interface UserProgressRecordRepositoryInterface
{
    /**
     * @param int $feUserUid
     * @return UserProgressRecord[]
     */
    public function findByFeUser(int $feUserUid): array;

    /**
     * @param int $lessonUid
     * @return UserProgressRecord[]
     */
    public function findByLesson(int $lessonUid): array;

    /**
     * @param ProgressRecordStatus|string $status
     * @return UserProgressRecord[]
     */
    public function findByStatus(ProgressRecordStatus|string $status): array;

    /**
     * @return QueryInterface<UserProgressRecord>
     */
    public function createQuery(): QueryInterface;
}

