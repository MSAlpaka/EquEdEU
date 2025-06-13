<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\UserProfile;
use Equed\EquedLms\Domain\Repository\UserProfileRepositoryInterface;

final class AuthService
{
    public function __construct(
        private readonly UserProfileRepositoryInterface $userProfileRepository
    ) {
    }

    /**
     * Get the role of a frontend user.
     *
     * @param int $frontendUserId
     * @return string One of 'certifier', 'instructor' or 'learner'
     */
    public function getUserRole(int $frontendUserId): string
    {
        $profile = $this->userProfileRepository->findByFeUser($frontendUserId);

        if ($profile instanceof UserProfile) {
            if ($profile->isCertifier()) {
                return 'certifier';
            }

            if ($profile->isInstructor()) {
                return 'instructor';
            }
        }

        return 'learner';
    }

    /**
     * Check if a frontend user is a certifier.
     *
     * @param int $frontendUserId
     * @return bool
     */
    public function isCertifier(int $frontendUserId): bool
    {
        return $this->getUserRole($frontendUserId) === 'certifier';
    }

    /**
     * Check if a frontend user is an instructor.
     *
     * @param int $frontendUserId
     * @return bool
     */
    public function isInstructor(int $frontendUserId): bool
    {
        return $this->getUserRole($frontendUserId) === 'instructor';
    }

    /**
     * Check if a frontend user is a learner.
     *
     * @param int $frontendUserId
     * @return bool
     */
    public function isLearner(int $frontendUserId): bool
    {
        return $this->getUserRole($frontendUserId) === 'learner';
    }
}
