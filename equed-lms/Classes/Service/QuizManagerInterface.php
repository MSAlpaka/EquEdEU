<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Dto\QuizListData;
use Equed\EquedLms\Dto\QuizViewData;
use Equed\EquedLms\Dto\QuizSubmissionRequest;
use Equed\EquedLms\Dto\QuizSubmissionResult;

interface QuizManagerInterface
{
    /**
     * Build the list of quizzes accessible to the user.
     */
    public function listQuizzes(int $userId): QuizListData;

    /**
     * Load quiz with questions or return an error message.
     */
    public function getQuiz(int $quizId): QuizViewData;

    /**
     * Handle a quiz submission.
     */
    public function submit(QuizSubmissionRequest $request): QuizSubmissionResult;
}
