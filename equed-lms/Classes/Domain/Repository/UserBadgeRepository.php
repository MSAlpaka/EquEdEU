<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Domain\Model\UserBadge;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;
use Equed\EquedLms\Domain\Repository\UserBadgeRepositoryInterface;

/**
 * Repository for UserBadge entities.
 *
 * @extends Repository<UserBadge>
 */
final class UserBadgeRepository extends Repository implements UserBadgeRepositoryInterface
{
    /**
     * Default ordering: newest badges first.
     *
     * @var array<string,int>
     */
    protected array $defaultOrderings = [
        'earnedAt' => QueryInterface::ORDER_DESCENDING,
    ];

    /**
     * Find all badges earned by a specific user.
     *
     * @param FrontendUser $user
     * @return UserBadge[]
     */
    public function findByUser(FrontendUser $user): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('feUser', $user)
        );

        return $query->execute()->toArray();
    }

    /**
     * Find all badges of a specific type.
     *
     * @param string $badgeType
     * @return UserBadge[]
     */
    public function findByBadgeType(string $badgeType): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('badgeType', $badgeType)
        );

        return $query->execute()->toArray();
    }

    /**
     * Find all badges issued via a specific source (e.g., course, external, manual).
     *
     * @param string $source
     * @return UserBadge[]
     */
    public function findBySource(string $source): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('source', $source)
        );

        return $query->execute()->toArray();
    }

    /**
     * Find all valid badges for a user.
     *
     * @param int $userId Frontend user UID
     * @return UserBadge[]
     */
    public function findValidBadges(int $userId): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('feUser', $userId)
        );

        return $query->execute()->toArray();
    }

    /**
     * Count valid badges for a user.
     *
     * @param int $userId Frontend user UID
     * @return int
     */
    public function countValidBadges(int $userId): int
    {
        $qb = $this->createQuery()->getQueryBuilder();
        $qb
            ->select($qb->expr()->count('*'))
            ->from('tx_equedlms_domain_model_userbadge')
            ->where(
                $qb->expr()->eq('user', $qb->createNamedParameter($userId, \PDO::PARAM_INT))
            );

        $result = $qb->executeQuery()->fetchOne();

        return $result === false ? 0 : (int)$result;
    }

    /**
     * Find a badge by user ID and badge type.
     *
     * @param int    $userId Frontend user UID
     * @param string $type   Badge type identifier
     * @return UserBadge|null
     */
    public function findByUserAndType(int $userId, string $type): ?UserBadge
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd([
                $query->equals('feUser', $userId),
                $query->equals('badgeType', $type),
            ])
        );
        $query->setLimit(1);

        return $query->execute()->getFirst();
    }

    /**
     * Count badges by user ID and badge identifier.
     *
     * @param int    $userId     Frontend user UID
     * @param string $identifier Badge type identifier
     * @return int
     */
    public function countByUserAndIdentifier(int $userId, string $identifier): int
    {
        $qb = $this->createQuery()->getQueryBuilder();
        $qb
            ->select($qb->expr()->count('*'))
            ->from('tx_equedlms_domain_model_userbadge')
            ->where(
                $qb->expr()->eq('user', $qb->createNamedParameter($userId, \PDO::PARAM_INT)),
                $qb->expr()->eq('badge_type', $qb->createNamedParameter($identifier))
            );

        $result = $qb->executeQuery()->fetchOne();

        return $result === false ? 0 : (int)$result;
    }
}
// EOF
