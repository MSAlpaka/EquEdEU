<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\UserBadge;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

interface UserBadgeRepositoryInterface
{
    /**
     * @param int $userId
     * @return UserBadge[]
     */
    public function findValidBadges(int $userId): array;

    /**
     * @param int $userId
     * @return int
     */
    public function countValidBadges(int $userId): int;

    /**
     * @param int    $userId
     * @param string $type
     * @return UserBadge|null
     */
    public function findByUserAndType(int $userId, string $type): ?UserBadge;

    /**
     * @param string $uuid
     * @return UserBadge|null
     */
    public function findByUuid(string $uuid): ?UserBadge;

    /**
     * @param int    $userId
     * @param string $identifier
     * @return int
     */
    public function countByUserAndIdentifier(int $userId, string $identifier): int;

    /**
     * @param UserBadge $badge
     * @return void
     */
    public function add(UserBadge $badge): void;

    /**
     * @return QueryInterface<UserBadge>
     */
    public function createQuery(): QueryInterface;
}
