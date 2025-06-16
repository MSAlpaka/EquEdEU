<?php

declare(strict_types=1);

namespace Equed\EquedLms\Dto;

use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;

final class ValidationRejectRequest
{
    public function __construct(
        private readonly int $recordId,
        private readonly string $feedback,
        private readonly int $certifierId,
    ) {
    }

    public static function fromRequest(ServerRequestInterface $request): self
    {
        $user = $request->getAttribute('user');
        $certifierId = is_array($user) && isset($user['uid']) ? (int)$user['uid'] : 0;
        $body = (array) $request->getParsedBody();
        $recordId = isset($body['recordId']) ? (int) $body['recordId'] : 0;
        $feedback = isset($body['feedback']) ? trim((string) $body['feedback']) : '';

        if ($certifierId <= 0 || $recordId <= 0 || $feedback === '') {
            throw new InvalidArgumentException('Invalid rejection input');
        }

        return new self($recordId, $feedback, $certifierId);
    }

    public function getRecordId(): int
    {
        return $this->recordId;
    }

    public function getFeedback(): string
    {
        return $this->feedback;
    }

    public function getCertifierId(): int
    {
        return $this->certifierId;
    }
}
