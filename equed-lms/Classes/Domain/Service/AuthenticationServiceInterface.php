<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Service;

use Equed\EquedLms\Domain\Model\FrontendUser;

interface AuthenticationServiceInterface
{
    /**
     * Validate credentials and return the matching user if valid.
     */
    public function validateCredentials(string $email, string $password): ?FrontendUser;

    public function getUserById(int $userId): ?FrontendUser;

    /**
     * Create a JWT token for the given user.
     */
    public function createToken(FrontendUser $user): string;

    /**
     * Authenticate and issue a token for the user.
     *
     * @return array{token: string, user: FrontendUser}|null
     */
    public function login(string $email, string $password): ?array;

    /**
     * Perform logout housekeeping.
     */
    public function logout(): void;
}
