<?php
declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

/**
 * Repository interface for accessing frontend user account data.
 */
interface FrontendUserAccountRepositoryInterface
{
    /**
     * Fetch profile information for a frontend user.
     *
     * @param int $userId FE user identifier
     * @return array<string,mixed>|null Raw profile data or null if not found
     */
    public function fetchProfile(int $userId): ?array;

    /**
     * Update profile fields for a frontend user.
     *
     * @param int $userId FE user identifier
     * @param array<string,mixed> $fields Fields to update
     */
    public function updateProfile(int $userId, array $fields): void;
}
