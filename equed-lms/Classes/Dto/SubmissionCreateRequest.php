<?php

declare(strict_types=1);

namespace Equed\EquedLms\Dto;

use Psr\Http\Message\ServerRequestInterface;

final class SubmissionCreateRequest
{
    public function __construct(
        private readonly int $userId,
        private readonly int $recordId,
        private readonly string $note,
        private readonly string $file,
        private readonly string $type,
    ) {
    }

    public static function fromRequest(ServerRequestInterface $request): self
    {
        $user = $request->getAttribute('user');
        $userId = is_array($user) && isset($user['uid']) ? (int)$user['uid'] : 0;
        $body = (array) $request->getParsedBody();

        $recordId = isset($body['userCourseRecord']) ? (int)$body['userCourseRecord'] : 0;
        $note = isset($body['note']) ? trim((string)$body['note']) : '';
        $file = isset($body['file']) ? trim((string)$body['file']) : '';
        $type = isset($body['type']) ? trim((string)$body['type']) : 'general';

        return new self($userId, $recordId, $note, $file, $type);
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getRecordId(): int
    {
        return $this->recordId;
    }

    public function getNote(): string
    {
        return $this->note;
    }

    public function getFile(): string
    {
        return $this->file;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
