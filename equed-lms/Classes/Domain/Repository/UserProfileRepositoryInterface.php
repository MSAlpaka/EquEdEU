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

    /**
     * @param UserProfile $profile
     */
    public function add($object);

    /**
     * @param UserProfile $profile
     */
    public function update($object);

    public function createQuery();
}
