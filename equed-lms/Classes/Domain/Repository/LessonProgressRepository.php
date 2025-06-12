<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Extbase\Persistence\Repository;
use Equed\EquedLms\Domain\Model\Lesson;
use Equed\EquedLms\Domain\Model\LessonProgress;
use Equed\EquedLms\Domain\Repository\LessonProgressRepositoryInterface;

/**
 * Repository for LessonProgress entries.

 *
 * @extends Repository<LessonProgress>
 *
 * Uses QueryBuilder for efficient scalar queries,
 * returns only needed fields,
 * fully DI-capable via ConnectionPool.
 */
final class LessonProgressRepository extends Repository implements LessonProgressRepositoryInterface
{
    private Connection $connection;

    public function __construct(ConnectionPool $connectionPool)
    {
        parent::__construct();
        $this->connection = $connectionPool->getConnectionForTable(
            'tx_equedlms_domain_model_lessonprogress'
        );
    }

    /**
     * Find lesson progress for a user and lesson.
     *
     * @param int $userId   Frontend user UID
     * @param int $lessonId Lesson UID
     * @return LessonProgress|null
     */
    public function findByUserAndLesson(int $userId, int $lessonId): ?LessonProgress
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd([
                $query->equals('feUser', $userId),
                $query->equals('lesson', $lessonId),
            ])
        );
        $query->setLimit(1);

        return $query->execute()->getFirst();
    }

    /**
     * Find all progress entries for a user.
     *
     * @param int $userId Frontend user UID
     * @return LessonProgress[]
     */
    public function findByUserId(int $userId): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('feUser', $userId)
        );

        return $query->execute()->toArray();
    }

    /**
     * Add or update a LessonProgress model.
     *
     * @param LessonProgress $progress Progress entity
     */
    public function updateOrAdd(LessonProgress $progress): void
    {
        if ($progress->getUid() === null) {
            $this->add($progress);
        } else {
            $this->update($progress);
        }
    }

    /**
     * Counts completed lessons for a user within a given list of lesson UIDs.
     *
     * @param int   $feUserId   Frontend user UID
     * @param int[] $lessonUids Array of lesson UIDs
     */
    public function countCompletedByUserAndLessons(int $feUserId, array $lessonUids): int
    {
        if ($feUserId <= 0 || $lessonUids === []) {
            return 0;
        }

        $qb = $this->connection->createQueryBuilder();
        $qb
            ->select($qb->expr()->count('uid'))
            ->from('tx_equedlms_domain_model_lessonprogress')
            ->where(
                $qb->expr()->eq('fe_user', $qb->createNamedParameter($feUserId, \PDO::PARAM_INT)),
                $qb->expr()->in('lesson', $qb->createNamedParameter($lessonUids, Connection::PARAM_INT_ARRAY)),
                $qb->expr()->eq('completed', $qb->createNamedParameter(1, \PDO::PARAM_INT))
            );

        $result = $qb->executeQuery()->fetchOne();

        return $result === false ? 0 : (int)$result;
    }
}
