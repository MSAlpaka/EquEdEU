<?php

declare(strict_types=1);

namespace Equed\EquedLms\Dto;

use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Data Transfer Object for sync requests coming from the app.
 */
final class SyncRequest
{
    /**
     * @param array<string, mixed> $payload
     */
    public function __construct(
        private readonly int $userId,
        private readonly array $payload,
    ) {
    }

    public static function fromRequest(ServerRequestInterface $request): self
    {
        $user = $request->getAttribute('user');
        $currentUserId = is_array($user) && isset($user['uid']) ? (int)$user['uid'] : 0;

        $body = (array) $request->getParsedBody();
        $payload = (array) ($body['payload'] ?? $body);
        $userId = isset($body['userId']) ? (int)$body['userId'] : $currentUserId;

        if ($userId <= 0) {
            throw new InvalidArgumentException('Invalid user identifier');
        }

        return new self($userId, $payload);
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return array<string, mixed>
     */
    public function getPayload(): array
    {
        return $this->payload;
    }
}
