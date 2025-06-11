<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\UserBadge;
use Equed\EquedLms\Domain\Repository\UserBadgeRepositoryInterface;

/**
 * Service for retrieving and checking user badges.
 */
final class UserBadgeService
{
    public function __construct(
        private readonly UserBadgeRepositoryInterface $userBadgeRepository
    ) {
    }

    /**
     * Returns all valid badges for a given user.
     *
     * @param int $userId FE user ID
     * @return UserBadge[] Array of UserBadge objects
     */
    public function getBadgesForUser(int $userId): array
    {
        return $this->userBadgeRepository->findValidBadges($userId);
    }

    /**
     * Determines whether a user has a badge with the specified identifier.
     *
     * @param int    $userId          FE user ID
     * @param string $badgeIdentifier Badge identifier
     * @return bool True if the badge exists for the user
     */
    public function hasBadge(int $userId, string $badgeIdentifier): bool
    {
        return $this->userBadgeRepository
            ->countByUserAndIdentifier($userId, $badgeIdentifier) > 0;
    }
}
