<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Service;

/**
 * Interface for JWT service implementations.
 */
interface JwtServiceInterface
{
    /**
     * Generate a JWT token for the given user data.
     *
     * @param array{uid:int|string, email:string, roles:array<string>} $userData
     * @return string
     */
    public function generateToken(array $userData): string;

    /**
     * Verify a JWT token and return its decoded payload.
     *
     * @param string $token
     * @return array<string,mixed>|null
     */
    public function verifyToken(string $token): ?array;
}
