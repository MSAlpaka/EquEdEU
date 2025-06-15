<?php

declare(strict_types=1);

namespace Equed\EquedLms\Dto;

final class QuizViewData implements \JsonSerializable
{
    public function __construct(
        private readonly ?object $quiz,
        private readonly array $questions,
        private readonly ?string $error = null,
    ) {
    }

    public function getQuiz(): ?object
    {
        return $this->quiz;
    }

    public function getQuestions(): array
    {
        return $this->questions;
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
            'quiz' => $this->quiz,
            'questions' => $this->questions,
            'error' => $this->error,
        ];
    }
}
