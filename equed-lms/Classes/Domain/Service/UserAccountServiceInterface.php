<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Service;

/**
 * Provides access to frontend user profile data.
 */
use Equed\EquedLms\Application\Dto\UserProfileDto;
use Equed\EquedLms\Dto\ProfileUpdateRequest;

interface UserAccountServiceInterface
{
    /**
     * Retrieve profile information for the given user.
     *
     * @param int $userId FE user identifier
     * @return UserProfileDto|null Profile data or null if not found
     */
    public function getProfile(int $userId): ?UserProfileDto;

    /**
     * Update profile fields for the given user.
     *
     * @param int $userId FE user identifier
     * @param ProfileUpdateRequest $request DTO containing fields to update
     */
    public function updateProfile(int $userId, ProfileUpdateRequest $request): void;
}

