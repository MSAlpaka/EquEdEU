<?php

declare(strict_types=1);

namespace Equed\EquedLms\Dto;

use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;

final class LoginRequest
{
    public function __construct(
        private readonly string $email,
        private readonly string $password,
    ) {
    }

    public static function fromRequest(ServerRequestInterface $request): self
    {
        $body = (array) $request->getParsedBody();
        $email = isset($body['email']) ? trim((string) $body['email']) : '';
        $password = isset($body['password']) ? (string) $body['password'] : '';

        if ($email === '' || $password === '') {
            throw new InvalidArgumentException('Missing credentials');
        }

        return new self($email, $password);
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}

