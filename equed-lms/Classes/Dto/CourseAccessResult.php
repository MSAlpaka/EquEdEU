<?php

declare(strict_types=1);

namespace Equed\EquedLms\Dto;

final class CourseAccessResult implements \JsonSerializable
{
    public function __construct(
        private readonly bool $granted,
        private readonly ?string $error = null
    ) {
    }

    public function isGranted(): bool
    {
        return $this->granted;
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
            'granted' => $this->granted,
            'error' => $this->error,
        ];
    }
}
