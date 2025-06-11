<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\UserProfile;
use Equed\EquedLms\Domain\Repository\UserProfileRepositoryInterface;

/**
 * Service for retrieving and checking user profile status.
 */
final class UserProfileService
{
    public function __construct(
        private readonly UserProfileRepositoryInterface $userProfileRepository
    ) {
    }

    /**
     * Returns the instructor profile for a given user, or null if not an instructor.
     *
     * @param int $userId FE user ID
     * @return UserProfile|null
     */
    public function getInstructorProfile(int $userId): ?UserProfile
    {
        $profile = $this->userProfileRepository->findByUserId($userId);
        return ($profile !== null && $profile->isInstructor()) ? $profile : null;
    }

    /**
     * Checks whether the user has completed onboarding.
     *
     * @param int $userId FE user ID
     * @return bool True if onboarding is complete
     */
    public function hasCompletedOnboarding(int $userId): bool
    {
        $profile = $this->userProfileRepository->findByUserId($userId);
        return $profile?->getOnboardingComplete() ?? false;
    }
}
