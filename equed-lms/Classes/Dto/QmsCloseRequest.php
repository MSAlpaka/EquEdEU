<?php

declare(strict_types=1);

namespace Equed\EquedLms\Dto;

use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;

final class QmsCloseRequest
{
    public function __construct(
        private readonly int $userId,
        private readonly int $caseId,
    ) {
    }

    public static function fromRequest(ServerRequestInterface $request): self
    {
        $user = $request->getAttribute('user');
        $userId = is_array($user) && isset($user['uid']) ? (int)$user['uid'] : 0;
        $body = (array) $request->getParsedBody();

        $caseId = isset($body['qmsId']) ? (int)$body['qmsId'] : 0;

        if ($userId <= 0 || $caseId <= 0) {
            throw new InvalidArgumentException('Invalid QMS close input');
        }

        return new self($userId, $caseId);
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getCaseId(): int
    {
        return $this->caseId;
    }
}
