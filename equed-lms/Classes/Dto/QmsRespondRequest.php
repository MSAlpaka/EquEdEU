<?php

declare(strict_types=1);

namespace Equed\EquedLms\Dto;

use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;

final class QmsRespondRequest
{
    public function __construct(
        private readonly int $userId,
        private readonly int $caseId,
        private readonly string $response,
        private readonly string $role = 'certifier',
    ) {
    }

    public static function fromRequest(ServerRequestInterface $request): self
    {
        $user = $request->getAttribute('user');
        $userId = is_array($user) && isset($user['uid']) ? (int)$user['uid'] : 0;
        $body = (array) $request->getParsedBody();

        $caseId   = isset($body['qmsId']) ? (int)$body['qmsId'] : 0;
        $response = isset($body['response']) ? trim((string)$body['response']) : '';
        $role     = isset($body['role']) ? trim((string)$body['role']) : 'certifier';

        if ($userId <= 0 || $caseId <= 0 || $response === '') {
            throw new InvalidArgumentException('Invalid QMS response input');
        }

        return new self($userId, $caseId, $response, $role);
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getCaseId(): int
    {
        return $this->caseId;
    }

    public function getResponse(): string
    {
        return $this->response;
    }

    public function getRole(): string
    {
        return $this->role;
    }
}
