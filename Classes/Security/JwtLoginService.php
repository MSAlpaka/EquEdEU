<?php

declare(strict_types=1);

namespace Equed\EquedCore\Security;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtLoginService
{
    public const ENV_SECRET = 'JWT_LOGIN_SECRET';

    public function __construct(
        private readonly TwoFactorService $twoFactorService,
        private ?string $secret = null,
    ) {
        $this->secret = $secret ?? (string) getenv(self::ENV_SECRET);
    }

    /**
     * @param array<string,mixed> $payload
     */
    public function generateToken(array $payload, int $ttl = 3600): string
    {
        $payload['iat'] = time();
        $payload['exp'] = time() + $ttl;
        return JWT::encode($payload, $this->secret, 'HS256');
    }

    /**
     * @return array<string,mixed>|null
     */
    public function verifyToken(string $token): ?array
    {
        try {
            $data = JWT::decode($token, new Key($this->secret, 'HS256'));
            return (array) $data;
        } catch (\Throwable) {
            return null;
        }
    }

    /**
     * @param array<string,mixed> $userRecord
     */
    public function authenticate(string $token, array $userRecord): bool
    {
        $payload = $this->verifyToken($token);
        if (!$payload) {
            return false;
        }

        if (!empty($userRecord['tx_equedcore_2fa_enabled'])) {
            $secret = (string) ($userRecord['tx_equedcore_2fa_secret'] ?? '');
            $code = (string) ($payload['2fa_code'] ?? '');
            if (!$this->twoFactorService->verifyCode($secret, $code)) {
                return false;
            }
        }

        return true;
    }
}
