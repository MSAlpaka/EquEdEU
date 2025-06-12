<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Domain\Model\UserProfile;
use Equed\EquedLms\Enum\BadgeLevel;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;
use Equed\EquedLms\Domain\Repository\UserProfileRepositoryInterface;

/**
 * Repository for UserProfile entities.
 *
 * @extends Repository<UserProfile>
 */
final class UserProfileRepository extends Repository implements UserProfileRepositoryInterface
{
    /**
     * Default ordering: newest profiles first.
     *
     * @var array<string,int>
     */
    protected $defaultOrderings = [
        'updatedAt' => QueryInterface::ORDER_DESCENDING,
    ];

    /**
     * Find profile by associated frontend user.
     *
     * @param FrontendUser $user
     * @return UserProfile|null
     */
    public function findByUser(FrontendUser $user): ?UserProfile
    {
        $query = $this->createQuery();

        return $query
            ->matching(
                $query->equals('user', $user)
            )
            ->execute()
            ->getFirst();
    }

    /**
     * Find all visible-in-search profiles.
     *
     * @return UserProfile[]
     */
    public function findVisible(): array
    {
        $query = $this->createQuery();

        return $query
            ->matching(
                $query->equals('isVisibleInSearch', true)
            )
            ->execute()
            ->toArray();
    }

    /**
     * Find profiles by documentation level.
     *
     * @param string $level Enum: beginner, advanced, pro, master
     * @return UserProfile[]
     */
    public function findByDocuLevel(string $level): array
    {
        $query = $this->createQuery();

        return $query
            ->matching(
                $query->equals('docuLevel', $level)
            )
            ->execute()
            ->toArray();
    }

    /**
     * Find profiles by badge level.
     *
     * @param BadgeLevel $badgeLevel
     * @return UserProfile[]
     */
    public function findByBadgeLevel(BadgeLevel $badgeLevel): array
    {
        $query = $this->createQuery();

        return $query
            ->matching(
                $query->equals('badgeLevel', $badgeLevel->value)
            )
            ->execute()
            ->toArray();
    }

    /**
     * Find profiles by status.
     *
     * @param string $status Enum: active, paused, review
     * @return UserProfile[]
     */
    public function findByStatus(string $status): array
    {
        $query = $this->createQuery();

        return $query
            ->matching(
                $query->equals('profileStatus', $status)
            )
            ->execute()
            ->toArray();
    }

    /**
     * Find profiles with pro access.
     *
     * @return UserProfile[]
     */
    public function findWithProAccess(): array
    {
        $query = $this->createQuery();

        return $query
            ->matching(
                $query->equals('hasProAccess', true)
            )
            ->execute()
            ->toArray();
    }

    public function findByFeUser(int $feUserId): ?UserProfile
    {
        $query = $this->createQuery();

        return $query
            ->matching(
                $query->equals('user', $feUserId)
            )
            ->execute()
            ->getFirst();
    }

    /**
     * @return UserProfile[]
     */
    public function findByInstructorStatus(bool $isInstructor): array
    {
        $query = $this->createQuery();

        return $query
            ->matching(
                $query->equals('isInstructor', $isInstructor)
            )
            ->execute()
            ->toArray();
    }

    public function findByUserId(int $userId): ?UserProfile
    {
        return $this->findByFeUser($userId);
    }
}
// End of file
