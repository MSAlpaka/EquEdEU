<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Service\JwtService;
use Equed\EquedLms\Domain\Service\ClockInterface;
use PHPUnit\Framework\TestCase;
use DateTimeImmutable;
use Firebase\JWT\Key;

final class JwtServiceTest extends TestCase
{
    public function testGenerateTokenIncludesPayloadFields(): void
    {
        $clock = new class() implements ClockInterface {
            public function now(): DateTimeImmutable { return new DateTimeImmutable('2024-01-01 00:00:00'); }
        };

        $service = new JwtService('secret', 3600, $clock);

        $token = $service->generateToken(['uid' => 5, 'email' => 't@example.com', 'roles' => ['a']]);
        $payload = (array) \Firebase\JWT\JWT::decode($token, new Key('secret', 'HS256'));

        $this->assertSame(5, $payload['uid']);
        $this->assertSame('t@example.com', $payload['email']);
        $this->assertSame(['a'], $payload['roles']);
        $this->assertSame(1704067200, $payload['iat']);
        $this->assertSame(1704070800, $payload['exp']);
    }

    public function testVerifyTokenReturnsNullOnError(): void
    {
        $clock = new class() implements ClockInterface {
            public function now(): DateTimeImmutable { return new DateTimeImmutable(); }
        };

        $service = new JwtService('secret', 3600, $clock);

        $this->assertNull($service->verifyToken('invalid'));
    }

    public function testVerifyTokenReturnsDecodedData(): void
    {
        $clock = new class() implements ClockInterface {
            public function now(): DateTimeImmutable { return new DateTimeImmutable(); }
        };

        $service = new JwtService('secret', 3600, $clock);
        $token = $service->generateToken(['uid' => 1, 'email' => 'a@b.c', 'roles' => []]);

        $data = $service->verifyToken($token);
        $this->assertIsArray($data);
        $this->assertSame(1, $data['uid']);
    }
}
