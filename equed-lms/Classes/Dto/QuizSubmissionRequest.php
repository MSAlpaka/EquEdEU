<?php

declare(strict_types=1);

namespace Equed\EquedLms\Dto;

final class QuizSubmissionRequest
{
    /** @param array<int,mixed> $answers */
    public function __construct(
        private readonly int $quizId,
        private readonly int $userId,
        private readonly array $answers,
    ) {
    }

    public function getQuizId(): int
    {
        return $this->quizId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    /** @return array<int,mixed> */
    public function getAnswers(): array
    {
        return $this->answers;
    }
}
