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
    protected $defaultOrderings = [
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

    public function findValidBadges(int $userId): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('feUser', $userId)
        );

        return $query->execute()->toArray();
    }

    public function countValidBadges(int $userId): int
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('feUser', $userId)
        );

        return $query->execute()->count();
    }

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

    public function countByUserAndIdentifier(int $userId, string $identifier): int
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd([
                $query->equals('feUser', $userId),
                $query->equals('badgeType', $identifier),
            ])
        );

        return $query->execute()->count();
    }
}
// EOF
