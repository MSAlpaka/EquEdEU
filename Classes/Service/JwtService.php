<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Equed\EquedLms\Domain\Service\JwtServiceInterface;

/**
 * Service for generating and validating JSON Web Tokens.
 */
final class JwtService implements JwtServiceInterface
{
    /**
     * @param string $jwtSecret Secret key for signing tokens
     * @param int    $tokenTtl  Time-to-live for tokens in seconds
     */
    public function __construct(
        private readonly string $jwtSecret,
        private readonly int $tokenTtl
    ) {
    }

    /**
     * Generate a JWT token for the given user data.
     *
     * @param array{uid:int|string, email:string, roles:array<string>} $userData
     * @return string Signed JWT token
     */
    public function generateToken(array $userData): string
    {
        $now     = time();
        $payload = [
            'iat'   => $now,
            'exp'   => $now + $this->tokenTtl,
            'uid'   => $userData['uid'] ?? null,
            'email' => $userData['email'] ?? '',
            'roles' => $userData['roles'] ?? [],
        ];

        return JWT::encode($payload, $this->jwtSecret, 'HS256');
    }

    /**
     * Verify a JWT token and return its decoded payload.
     *
     * @param string $token JWT token
     * @return array<string,mixed>|null Decoded payload or null if invalid
     */
    public function verifyToken(string $token): ?array
    {
        try {
            $decoded = JWT::decode($token, new Key($this->jwtSecret, 'HS256'));
            /** @var object $decoded */
            return json_decode(json_encode($decoded), true, 512, JSON_THROW_ON_ERROR);
        } catch (\Throwable) {
            return null;
        }
    }
}
