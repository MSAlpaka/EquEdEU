<?php

declare(strict_types=1);

namespace Equed\EquedLms\Dto;

use TYPO3\CMS\Core\Messaging\AbstractMessage;

final class QuizSubmissionResult implements \JsonSerializable
{
    public function __construct(
        private readonly object $result,
        private readonly string $message,
        private readonly int $severity = AbstractMessage::OK,
    ) {
    }

    public function getResult(): object
    {
        return $this->result;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getSeverity(): int
    {
        return $this->severity;
    }

    public function jsonSerialize(): array
    {
        return [
            'result' => $this->result,
            'message' => $this->message,
            'severity' => $this->severity,
        ];
    }
}
