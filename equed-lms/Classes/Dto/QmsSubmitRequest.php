<?php

declare(strict_types=1);

namespace Equed\EquedLms\Dto;

use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;

final class QmsSubmitRequest
{
    public function __construct(
        private readonly int $userId,
        private readonly int $recordId,
        private readonly string $message,
        private readonly string $type = 'general',
    ) {
    }

    public static function fromRequest(ServerRequestInterface $request): self
    {
        $user = $request->getAttribute('user');
        $userId = is_array($user) && isset($user['uid']) ? (int)$user['uid'] : 0;
        $body = (array) $request->getParsedBody();

        $recordId = isset($body['recordId']) ? (int)$body['recordId'] : 0;
        $message  = isset($body['message']) ? trim((string)$body['message']) : '';
        $type     = isset($body['type']) ? trim((string)$body['type']) : 'general';

        if ($userId <= 0 || $recordId <= 0 || $message === '') {
            throw new InvalidArgumentException('Invalid QMS submit input');
        }

        return new self($userId, $recordId, $message, $type);
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getRecordId(): int
    {
        return $this->recordId;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
