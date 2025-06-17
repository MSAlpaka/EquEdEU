<?php

declare(strict_types=1);

namespace Equed\EquedLms\Dto;

/**
 * Lightweight value object representing a submission error.
 */
final class SubmissionError implements \JsonSerializable
{
    public function __construct(private readonly string $message)
    {
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function jsonSerialize(): array
    {
        return ['message' => $this->message];
    }
}
