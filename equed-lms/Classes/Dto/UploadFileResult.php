<?php

declare(strict_types=1);

namespace Equed\EquedLms\Dto;

use TYPO3\CMS\Extbase\Domain\Model\FileReference;

final class UploadFileResult implements \JsonSerializable
{
    public function __construct(
        private readonly ?FileReference $fileReference,
        private readonly ?string $error = null
    ) {
    }

    public function getFileReference(): ?FileReference
    {
        return $this->fileReference;
    }

    public function getError(): ?string
    {
        return $this->error;
    }

    public function hasError(): bool
    {
        return $this->error !== null;
    }

    public function jsonSerialize(): array
    {
        return [
            'fileReference' => $this->fileReference,
            'error' => $this->error,
        ];
    }
}
