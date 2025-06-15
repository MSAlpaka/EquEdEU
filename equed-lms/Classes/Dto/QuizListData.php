<?php

declare(strict_types=1);

namespace Equed\EquedLms\Dto;

use TYPO3\CMS\Core\Messaging\AbstractMessage;

final class QuizListData implements \JsonSerializable
{
    public function __construct(
        private readonly array $quizzes,
        private readonly ?string $message = null,
        private readonly int $severity = AbstractMessage::OK,
    ) {
    }

    public function getQuizzes(): array
    {
        return $this->quizzes;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function getSeverity(): int
    {
        return $this->severity;
    }

    public function hasMessage(): bool
    {
        return $this->message !== null;
    }

    public function jsonSerialize(): array
    {
        return [
            'quizzes' => $this->quizzes,
            'message' => $this->message,
            'severity' => $this->severity,
        ];
    }
}
