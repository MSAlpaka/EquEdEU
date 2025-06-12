<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\UserProfile;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

interface UserProfileRepositoryInterface
{
    /**
     * @param int $feUserId
     * @return UserProfile|null
     */
    public function findByFeUser(int $feUserId): ?UserProfile;

    /**
     * @param bool $isInstructor
     * @return UserProfile[]
     */
    public function findByInstructorStatus(bool $isInstructor): array;

    /**
     * @param int $userId
     * @return UserProfile|null
     */
    public function findByUserId(int $userId): ?UserProfile;

    /**
     * @param UserProfile $profile
     * @return void
     */
    public function add(UserProfile $profile): void;

    /**
     * @param UserProfile $profile
     * @return void
     */
    public function update(UserProfile $profile): void;

    /**
     * @return QueryInterface<UserProfile>
     */
    public function createQuery(): QueryInterface;
}
