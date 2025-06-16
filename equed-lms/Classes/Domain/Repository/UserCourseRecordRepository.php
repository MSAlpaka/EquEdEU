<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\CourseInstance;
use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Domain\Model\UserCourseRecord;
use Equed\EquedLms\Enum\UserCourseStatus;
use Equed\EquedLms\Enum\BadgeLevel;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;
use Equed\EquedLms\Domain\Repository\UserCourseRecordRepositoryInterface;
use InvalidArgumentException;

/**
 * Repository for UserCourseRecord entities.
 *
 * @extends Repository<UserCourseRecord>
 */
final class UserCourseRecordRepository extends Repository implements UserCourseRecordRepositoryInterface
{
    /**
     * List of columns allowed for distinct lookup.
     *
     * @var string[]
     */
    private const ALLOWED_COLUMNS = ['badgeStatus'];

    /**
     * Default ordering: newest records first.
     *
     * @var array<string,int>
     */
    protected array $defaultOrderings = [
        'createdAt' => QueryInterface::ORDER_DESCENDING,
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
     * Find a course record by its UUID.
     *
     * @param string $uuid
     * @return UserCourseRecord|null
     */
    public function findByUuid(string $uuid): ?UserCourseRecord
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('uuid', $uuid)
        );
        $query->setLimit(1);

        return $query->execute()->getFirst();
    }

    /**
     * Find course records by status.
     *
     * @param UserCourseStatus|string $status Value from UserCourseStatus enum
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
     * Find completed course records without an assigned badge.
     *
     * @return UserCourseRecord[]
     */
    public function findCompletedWithoutBadge(): array
    {
        $qb = $this->createQuery()->getQueryBuilder();
        $qb
            ->select('ucr.uid')
            ->from('tx_equedlms_domain_model_usercourserecord', 'ucr')
            ->where(
                $qb->expr()->isNotNull('ucr.completed_at'),
                $qb->expr()->eq('ucr.badge_level', $qb->createNamedParameter(BadgeLevel::None->value))
            );

        $uids = $qb->executeQuery()->fetchFirstColumn();

        if ($uids === []) {
            return [];
        }

        $query = $this->createQuery();
        $query->matching($query->in('uid', array_map('intval', $uids)));

        return $query->execute()->toArray();
    }

    /**
     * Find the latest attempt record for a user and course instance.
     *
     * @param FrontendUser     $user
     * @param CourseInstance   $instance
     * @return UserCourseRecord|null
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
     * Find a course record for a user and course instance.
     *
     * @param int $userId          Frontend user UID
     * @param int $courseInstanceId Course instance UID
     * @return UserCourseRecord|null
     */
    public function findOneByUserAndCourseInstance(int $userId, int $courseInstanceId): ?UserCourseRecord
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd([
                $query->equals('user', $userId),
                $query->equals('courseInstance', $courseInstanceId),
            ])
        );
        $query->setLimit(1);

        return $query->execute()->getFirst();
    }

    /**
     * Find a course record for a user and course.
     *
     * @param int $userId    Frontend user UID
     * @param int $courseUid Course UID
     * @return UserCourseRecord|null
     */
    public function findOneByUserAndCourse(int $userId, int $courseUid): ?UserCourseRecord
    {
        $qb = $this->createQuery()->getQueryBuilder();
        $qb
            ->select('ucr.uid')
            ->from('tx_equedlms_domain_model_usercourserecord', 'ucr')
            ->join('ucr', 'tx_equedlms_domain_model_courseinstance', 'ci', 'ci.uid = ucr.course_instance')
            ->join('ci', 'tx_equedlms_domain_model_course', 'c', 'c.courseprogram = ci.courseprogram')
            ->where(
                $qb->expr()->eq('ucr.fe_user', $qb->createNamedParameter($userId, \PDO::PARAM_INT)),
                $qb->expr()->eq('c.uid', $qb->createNamedParameter($courseUid, \PDO::PARAM_INT))
            )
            ->setMaxResults(1);

        $uid = $qb->executeQuery()->fetchOne();

        return is_numeric($uid) ? $this->findByUid((int) $uid) : null;
    }

    /**
     * Find course records by instructor of the course instance.
     *
     * @param int $instructorId Frontend user UID of the instructor
     * @return UserCourseRecord[]
     */
    public function findByInstructor(int $instructorId): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('courseInstance.instructor', $instructorId)
        );

        return $query->execute()->toArray();
    }

    /**
     * Find course records for a frontend user.
     *
     * @param int $feUserId Frontend user UID
     * @return UserCourseRecord[]
     */
    public function findByFeUser(int $feUserId): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('user', $feUserId)
        );

        return $query->execute()->toArray();
    }

    /**
     * Find course records by user ID.
     *
     * @param int $userId Frontend user UID
     * @return UserCourseRecord[]
     */
    public function findByUserId(int $userId): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('user', $userId)
        );

        return $query->execute()->toArray();
    }

    /**
     * Find course records for a user and course instance.
     *
     * @param int $userId          Frontend user UID
     * @param int $courseInstanceId Course instance UID
     * @return UserCourseRecord[]
     */
    public function findByUserAndCourseInstance(int $userId, int $courseInstanceId): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd([
                $query->equals('user', $userId),
                $query->equals('courseInstance', $courseInstanceId),
            ])
        );

        return $query->execute()->toArray();
    }

    /**
     * Find course records for a user filtered by status.
     *
     * @param int                       $userId Frontend user UID
     * @param UserCourseStatus|string    $status Status value from UserCourseStatus
     * @return UserCourseRecord[]
     */
    public function findByUserAndStatus(int $userId, UserCourseStatus|string $status): array
    {
        if (is_string($status)) {
            $status = UserCourseStatus::from($status);
        }

        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd([
                $query->equals('user', $userId),
                $query->equals('status', $status->value),
            ])
        );

        return $query->execute()->toArray();
    }

    /**
     * Count records by status.
     *
     * @param UserCourseStatus|string $status
     * @return int
     */
    public function countByStatus(UserCourseStatus|string $status): int
    {
        if (is_string($status)) {
            $status = UserCourseStatus::from($status);
        }

        $qb = $this->createQuery()->getQueryBuilder();
        $qb
            ->select($qb->expr()->count('*'))
            ->from('tx_equedlms_domain_model_usercourserecord')
            ->where(
                $qb->expr()->eq('status', $qb->createNamedParameter($status->value))
            );

        $result = $qb->executeQuery()->fetchOne();

        return $result === false ? 0 : (int) $result;
    }

    /**
     * Count records for a frontend user.
     *
     * @return int
     */
    public function countByUserId(int $userId): int
    {
        $qb = $this->createQuery()->getQueryBuilder();
        $qb
            ->select($qb->expr()->count('*'))
            ->from('tx_equedlms_domain_model_usercourserecord')
            ->where(
                $qb->expr()->eq('fe_user', $qb->createNamedParameter($userId, \PDO::PARAM_INT))
            );

        $result = $qb->executeQuery()->fetchOne();

        return $result === false ? 0 : (int) $result;
    }

    /**
     * Count records for a user filtered by status.
     *
     * @param UserCourseStatus|string $status
     * @return int
     */
    public function countByUserIdAndStatus(int $userId, UserCourseStatus|string $status): int
    {
        if (is_string($status)) {
            $status = UserCourseStatus::from($status);
        }

        $qb = $this->createQuery()->getQueryBuilder();
        $qb
            ->select($qb->expr()->count('*'))
            ->from('tx_equedlms_domain_model_usercourserecord')
            ->where(
                $qb->expr()->eq('fe_user', $qb->createNamedParameter($userId, \PDO::PARAM_INT)),
                $qb->expr()->eq('status', $qb->createNamedParameter($status->value))
            );

        $result = $qb->executeQuery()->fetchOne();

        return $result === false ? 0 : (int) $result;
    }

    /**
     * Count records for a user and course instance with status filter.
     *
     * @param UserCourseStatus|string $status
     * @return int
     */
    public function countByUserAndInstanceAndStatus(int $userId, int $courseInstanceId, UserCourseStatus|string $status): int
    {
        if (is_string($status)) {
            $status = UserCourseStatus::from($status);
        }

        $qb = $this->createQuery()->getQueryBuilder();
        $qb
            ->select($qb->expr()->count('*'))
            ->from('tx_equedlms_domain_model_usercourserecord')
            ->where(
                $qb->expr()->eq('fe_user', $qb->createNamedParameter($userId, \PDO::PARAM_INT)),
                $qb->expr()->eq('course_instance', $qb->createNamedParameter($courseInstanceId, \PDO::PARAM_INT)),
                $qb->expr()->eq('status', $qb->createNamedParameter($status->value))
            );

        $result = $qb->executeQuery()->fetchOne();

        return $result === false ? 0 : (int) $result;
    }

    /**
     * Count records for a user within a course program.
     *
     * @return int
     */
    public function countByUserIdAndCourseProgram(int $userId, int $courseProgramId): int
    {
        $qb = $this->createQuery()->getQueryBuilder();
        $qb
            ->select($qb->expr()->count('*'))
            ->from('tx_equedlms_domain_model_usercourserecord', 'ucr')
            ->join(
                'ucr',
                'tx_equedlms_domain_model_courseinstance',
                'ci',
                'ci.uid = ucr.course_instance'
            )
            ->where(
                $qb->expr()->eq('ucr.fe_user', $qb->createNamedParameter($userId, \PDO::PARAM_INT)),
                $qb->expr()->eq('ci.courseprogram', $qb->createNamedParameter($courseProgramId, \PDO::PARAM_INT))
            );

        $result = $qb->executeQuery()->fetchOne();

        return $result === false ? 0 : (int) $result;
    }

    /**
     * Return a list of distinct values for a given field.
     *
     * @param string $field Database field name
     * @return array<int, mixed>
     */
    public function findDistinctField(string $field): array
    {
        if (!in_array($field, self::ALLOWED_COLUMNS, true)) {
            throw new InvalidArgumentException(sprintf('Column "%s" is not allowed', $field));
        }

        $column = $field;
        $queryBuilder = $this->createQuery()->getQueryBuilder();
        $rows = $queryBuilder
            ->selectDistinct($column)
            ->from('tx_equedlms_domain_model_usercourserecord')
            ->executeQuery()
            ->fetchFirstColumn();

        return array_values(array_filter($rows, static fn ($v) => $v !== null && $v !== ''));
    }
}
