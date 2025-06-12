<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\UserBadge;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

interface UserBadgeRepositoryInterface
{
    /**
     * @return UserBadge[]
     */
    public function findValidBadges(int $userId): array;

    public function countValidBadges(int $userId): int;

    public function findByUserAndType(int $userId, string $type): ?UserBadge;

    public function findByUuid(string $uuid): ?UserBadge;

    public function countByUserAndIdentifier(int $userId, string $identifier): int;

    public function add(UserBadge $badge): void;

    /**
     * @return QueryInterface<UserBadge>
     */
    public function createQuery(): QueryInterface;
}
