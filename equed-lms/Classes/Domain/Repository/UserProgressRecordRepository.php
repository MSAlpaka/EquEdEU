<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\UserProgressRecord;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository for UserProgressRecord entities.
 *
 * @extends Repository<UserProgressRecord>
 */
final class UserProgressRecordRepository extends Repository
{
    /**
     * Default ordering: oldest progress first.
     *
     * @var array<string,int>
     */
    protected $defaultOrderings = [
        'createdAt' => QueryInterface::ORDER_ASCENDING,
    ];

    /**
     * Find all progress records for a given instructor.
     *
     * @param int $feUserUid
     * @return UserProgressRecord[]
     */
    public function findByFeUser(int $feUserUid): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('instructor', $feUserUid)
        );

        return $query->execute()->toArray();
    }

    /**
     * Find all progress records for a specific lesson.
     *
     * @param int $lessonUid
     * @return UserProgressRecord[]
     */
    public function findByLesson(int $lessonUid): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('lesson', $lessonUid)
        );

        return $query->execute()->toArray();
    }

    /**
     * Find all progress records by status.
     *
     * @param string $status One of 'incomplete', 'complete', 'passed'
     * @return UserProgressRecord[]
     */
    public function findByStatus(string $status): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('status', $status)
        );

        return $query->execute()->toArray();
    }
}
// EOF
