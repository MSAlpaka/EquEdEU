<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\UserProfile;
use Equed\EquedLms\Domain\Repository\UserProfileRepositoryInterface;
use Equed\EquedLms\Enum\UserRole;

final class AuthService implements AuthServiceInterface
{
    /**
     * Cache of resolved user roles indexed by frontend user ID.
     *
     * @var array<int, UserRole>
     */
    private array $roleCache = [];

    public function __construct(
        private readonly UserProfileRepositoryInterface $userProfileRepository
    ) {
    }

    /**
     * Get the role of a frontend user.
     *
     * @param int $frontendUserId
     */
    public function getUserRole(int $frontendUserId): UserRole
    {
        if (isset($this->roleCache[$frontendUserId])) {
            return $this->roleCache[$frontendUserId];
        }

        $profile = $this->userProfileRepository->findByFeUser($frontendUserId);

        if ($profile instanceof UserProfile) {
            if ($profile->isCertifier()) {
                return $this->roleCache[$frontendUserId] = UserRole::Certifier;
            }

            if ($profile->isInstructor()) {
                return $this->roleCache[$frontendUserId] = UserRole::Instructor;
            }
        }

        return $this->roleCache[$frontendUserId] = UserRole::Learner;
    }

    /**
     * Check if a frontend user is a certifier.
     *
     * @param int $frontendUserId
     * @return bool
     */
    public function isCertifier(int $frontendUserId): bool
    {
        return $this->getUserRole($frontendUserId) === UserRole::Certifier;
    }

    /**
     * Check if a frontend user is an instructor.
     *
     * @param int $frontendUserId
     * @return bool
     */
    public function isInstructor(int $frontendUserId): bool
    {
        return $this->getUserRole($frontendUserId) === UserRole::Instructor;
    }

    /**
     * Check if a frontend user is a learner.
     *
     * @param int $frontendUserId
     * @return bool
     */
    public function isLearner(int $frontendUserId): bool
    {
        return $this->getUserRole($frontendUserId) === UserRole::Learner;
    }
}
