<?php

declare(strict_types=1);

namespace Equed\EquedLms\Dto;

use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;

final class UploadFileRequest
{
    public function __construct(
        private readonly int $userId,
        private readonly UploadedFileInterface $file,
        private readonly string $type,
        private readonly string $description
    ) {
    }

    public static function fromRequest(ServerRequestInterface $request): self
    {
        $user = $request->getAttribute('user');
        $userId = is_array($user) && isset($user['uid']) ? (int)$user['uid'] : 0;

        $body = (array)$request->getParsedBody();
        $type = isset($body['type']) && $body['type'] !== '' ? trim((string)$body['type']) : 'general';
        $description = isset($body['description']) ? trim((string)$body['description']) : '';

        $files = $request->getUploadedFiles();
        if (!isset($files['file']) || !$files['file'] instanceof UploadedFileInterface) {
            throw new InvalidArgumentException('Invalid uploaded file');
        }

        $file = $files['file'];
        if ($file->getError() !== UPLOAD_ERR_OK) {
            throw new InvalidArgumentException('File upload error');
        }

        return new self($userId, $file, $type, $description);
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getFile(): UploadedFileInterface
    {
        return $this->file;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
