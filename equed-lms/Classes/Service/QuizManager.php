<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\Core\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Repository\QuizRepositoryInterface;
use Equed\EquedLms\Domain\Repository\QuestionRepositoryInterface;
use Equed\EquedLms\Domain\Service\QuizSubmissionServiceInterface;
use Equed\EquedLms\Dto\QuizListData;
use Equed\EquedLms\Dto\QuizViewData;
use Equed\EquedLms\Dto\QuizSubmissionRequest;
use Equed\EquedLms\Dto\QuizSubmissionResult;
use TYPO3\CMS\Core\Messaging\AbstractMessage;

final class QuizManager implements QuizManagerInterface
{
    public function __construct(
        private readonly QuizRepositoryInterface $quizRepository,
        private readonly QuestionRepositoryInterface $questionRepository,
        private readonly QuizSubmissionServiceInterface $quizSubmissionService,
        private readonly ConfigurationServiceInterface $configurationService,
        private readonly GptTranslationServiceInterface $translationService,
    ) {
    }

    public function listQuizzes(int $userId): QuizListData
    {
        if (!$this->configurationService->isFeatureEnabled('quiz_module')) {
            $message = $this->translationService->translate('controller.quiz.list.disabled');
            return new QuizListData([], $message, AbstractMessage::WARNING);
        }

        $quizzes = $this->quizRepository->findAvailableByUser($userId);
        return new QuizListData($quizzes);
    }

    public function getQuiz(int $quizId): QuizViewData
    {
        if ($quizId <= 0) {
            $message = $this->translationService->translate('controller.quiz.show.invalid');
            return new QuizViewData(null, [], $message);
        }

        $quiz = $this->quizRepository->findByUid($quizId);
        if ($quiz === null) {
            $message = $this->translationService->translate('controller.quiz.show.notFound');
            return new QuizViewData(null, [], $message);
        }

        $questions = $this->questionRepository->findByQuiz($quiz);
        return new QuizViewData($quiz, $questions);
    }

    public function submit(QuizSubmissionRequest $request): QuizSubmissionResult
    {
        $result = $this->quizSubmissionService->submitAnswers(
            $request->getQuizId(),
            $request->getUserId(),
            $request->getAnswers()
        );

        $message = $this->translationService->translate(
            'controller.quiz.submit.processed',
            null,
            ['{score}' => (string)$result->getScore()]
        );

        return new QuizSubmissionResult($result, $message);
    }
}
