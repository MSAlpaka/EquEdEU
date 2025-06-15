<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Service;

/**
 * Provides access to frontend user profile data.
 */
interface UserAccountServiceInterface
{
    /**
     * Retrieve profile information for the given user.
     *
     * @param int $userId FE user identifier
     * @return array<string,mixed>|null Profile data or null if not found
     */
    public function getProfile(int $userId): ?array;

    /**
     * Update profile fields for the given user.
     *
     * @param int $userId FE user identifier
     * @param array<string,mixed> $fields Fields to update
     */
    public function updateProfile(int $userId, array $fields): void;
}

