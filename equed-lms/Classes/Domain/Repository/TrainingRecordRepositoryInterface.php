<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\TrainingRecord;
use Equed\EquedLms\Domain\Model\UserCourseRecord;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

interface TrainingRecordRepositoryInterface
{
    /**
     * @param UserCourseRecord $ucr
     * @return TrainingRecord[]
     */
    public function findByUserCourseRecord(UserCourseRecord $ucr): array;

    /**
     * @param UserCourseRecord $ucr
     * @return TrainingRecord[]
     */
    public function findValidatedByUserCourseRecord(UserCourseRecord $ucr): array;

    /**
     * @param UserCourseRecord $ucr
     * @param string           $type
     * @return TrainingRecord[]
     */
    public function findByType(UserCourseRecord $ucr, string $type): array;

    /**
     * @param UserCourseRecord   $ucr
     * @param \DateTimeImmutable $from
     * @param \DateTimeImmutable $to
     * @return TrainingRecord[]
     */
    public function findByDateRange(UserCourseRecord $ucr, \DateTimeImmutable $from, \DateTimeImmutable $to): array;

    /**
     * @return QueryInterface<TrainingRecord>
     */
    public function createQuery(): QueryInterface;
}

