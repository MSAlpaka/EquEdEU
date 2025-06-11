<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\TrainingRecord;
use Equed\EquedLms\Domain\Model\UserCourseRecord;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository for TrainingRecord entities.
 *
 * Provides methods to fetch training records in accordance with
 * project standards: typed properties, PSR-12, strict types,
 * dependency injection compatibility, and Extbase Query API usage.
 *
 * @extends Repository<TrainingRecord>
 */
class TrainingRecordRepository extends Repository
{
    /**
     * Default ordering: newest first by creation date.
     *
     * @var array<string,int>
     */
    protected $defaultOrderings = [
        'createdAt' => QueryInterface::ORDER_DESCENDING,
    ];

    /**
     * Finds all training records for a given user course record.
     *
     * @param UserCourseRecord $ucr
     * @return TrainingRecord[]
     */
    public function findByUserCourseRecord(UserCourseRecord $ucr): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('userCourseRecord', $ucr)
        );

        return $query->execute()->toArray();
    }

    /**
     * Finds all validated training records for a given user course record.
     *
     * @param UserCourseRecord $ucr
     * @return TrainingRecord[]
     */
    public function findValidatedByUserCourseRecord(UserCourseRecord $ucr): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd([
                $query->equals('userCourseRecord', $ucr),
                $query->equals('isValidated', true),
            ])
        );

        return $query->execute()->toArray();
    }

    /**
     * Finds all training records of a specific type (self, guided, live, observation).
     *
     * @param UserCourseRecord $ucr
     * @param string           $type
     * @return TrainingRecord[]
     */
    public function findByType(UserCourseRecord $ucr, string $type): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd([
                $query->equals('userCourseRecord', $ucr),
                $query->equals('trainingType', $type),
            ])
        );

        return $query->execute()->toArray();
    }

    /**
     * Finds training records within a date range for a given user course record.
     *
     * @param UserCourseRecord     $ucr
     * @param \DateTimeImmutable   $from
     * @param \DateTimeImmutable   $to
     * @return TrainingRecord[]
     */
    public function findByDateRange(UserCourseRecord $ucr, \DateTimeImmutable $from, \DateTimeImmutable $to): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd([
                $query->equals('userCourseRecord', $ucr),
                $query->greaterThanOrEqual('date', $from),
                $query->lessThanOrEqual('date', $to),
            ])
        );

        return $query->execute()->toArray();
    }
}
// End of file
