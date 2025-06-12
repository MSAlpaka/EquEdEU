<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\UserProfile;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

interface UserProfileRepositoryInterface
{
    public function findByFeUser(int $feUserId): ?UserProfile;

    /**
     * @return UserProfile[]
     */
    public function findByInstructorStatus(bool $isInstructor): array;

    public function findByUserId(int $userId): ?UserProfile;

    public function add(UserProfile $profile): void;

    public function update(UserProfile $profile): void;

    /**
     * @return QueryInterface<UserProfile>
     */
    public function createQuery(): QueryInterface;
}
