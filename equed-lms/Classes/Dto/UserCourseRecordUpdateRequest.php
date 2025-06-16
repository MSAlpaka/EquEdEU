<?php

declare(strict_types=1);

namespace Equed\EquedLms\Dto;

use Psr\Http\Message\ServerRequestInterface;

final class UserCourseRecordUpdateRequest
{
    public function __construct(
        private readonly int $uid,
        private readonly string $status,
        private readonly ?int $progress,
    ) {
    }

    public static function fromRequest(ServerRequestInterface $request): self
    {
        $body = (array)$request->getParsedBody();

        $uid = isset($body['uid']) ? (int)$body['uid'] : 0;
        $status = isset($body['status']) ? trim((string)$body['status']) : '';
        $progress = isset($body['progress']) ? (int)$body['progress'] : null;

        return new self($uid, $status, $progress);
    }

    public function getUid(): int
    {
        return $this->uid;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getProgress(): ?int
    {
        return $this->progress;
    }
}
