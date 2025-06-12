<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\CourseInstance;
use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Domain\Model\UserCourseRecord;
use Equed\EquedLms\Enum\UserCourseStatus;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;
use Equed\EquedLms\Domain\Repository\UserCourseRecordRepositoryInterface;

/**
 * Repository for UserCourseRecord entities.
 *
 * @extends Repository<UserCourseRecord>
 */
final class UserCourseRecordRepository extends Repository implements UserCourseRecordRepositoryInterface
{
    /**
     * Default ordering: newest records first.
     *
     * @var array<string,int>
     */
    protected array $defaultOrderings = [
        'crdate' => QueryInterface::ORDER_DESCENDING,
    ];

    /**
     * Find all course records for a given frontend user.
     *
     * @param FrontendUser $user
     * @return UserCourseRecord[]
     */
    public function findByUser(FrontendUser $user): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('user', $user)
        );

        return $query->execute()->toArray();
    }

    /**
     * Find active course records for a user.
     *
     * Active records have the status "in_progress".
     *
     * @param FrontendUser $user
     * @return UserCourseRecord[]
     */
    public function findActiveByUser(FrontendUser $user): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd([
                $query->equals('user', $user),
                $query->equals('status', UserCourseStatus::InProgress->value),
            ])
        );

        return $query->execute()->toArray();
    }

    /**
     * Find all course records for a given course instance.
     *
     * @param CourseInstance $instance
     * @return UserCourseRecord[]
     */
    public function findByCourseInstance(CourseInstance $instance): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('courseInstance', $instance)
        );

        return $query->execute()->toArray();
    }

    /**
     * Find course records by status.
     *
     * @param string $status Enum: in_progress, failed, passed, validated
     * @return UserCourseRecord[]
     */
    public function findByStatus(UserCourseStatus|string $status): array
    {
        if (is_string($status)) {
            $status = UserCourseStatus::from($status);
        }

        $query = $this->createQuery();
        $query->matching(
            $query->equals('status', $status->value)
        );

        return $query->execute()->toArray();
    }

    /**
     * Find finalized course records.
     *
     * @return UserCourseRecord[]
     */
    public function findFinalized(): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('finalized', true)
        );

        return $query->execute()->toArray();
    }

    /**
     * Find course records validated by a certifier.
     *
     * @return UserCourseRecord[]
     */
    public function findValidated(): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('validatedByCertifier', true)
        );

        return $query->execute()->toArray();
    }

    /**
     * Find records with an external certificate.
     *
     * @return UserCourseRecord[]
     */
    public function findExternalCertificates(): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('externalCertificateFlag', true)
        );

        return $query->execute()->toArray();
    }

    /**
     * Find the latest attempt record for a user and course instance.
     *
     * @param FrontendUser     $user
     * @param CourseInstance   $instance
     */
    public function findLatestByUserAndInstance(FrontendUser $user, CourseInstance $instance): ?UserCourseRecord
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd([
                $query->equals('user', $user),
                $query->equals('courseInstance', $instance),
            ])
        );
        $query->setOrderings(['attemptNumber' => QueryInterface::ORDER_DESCENDING]);
        $query->setLimit(1);

        return $query->execute()->getFirst();
    }

    /**
     * Return a list of distinct values for a given field.
     *
     * @param string $field Database field name
     * @return array<int, mixed>
     */
    public function findDistinctField(string $field): array
    {
        $queryBuilder = $this->createQuery()->getQueryBuilder();
        $queryBuilder->resetQueryParts();
        $rows = $queryBuilder
            ->selectDistinct($field)
            ->from('tx_equedlms_domain_model_usercourserecord')
            ->executeQuery()
            ->fetchFirstColumn();

        return array_values(array_filter($rows, static fn ($v) => $v !== null && $v !== ''));
    }
}
// EOF
