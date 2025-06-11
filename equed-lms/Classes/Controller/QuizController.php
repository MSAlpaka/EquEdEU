<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller;

use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\Core\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Repository\QuizRepositoryInterface;
use Equed\EquedLms\Domain\Repository\QuestionRepositoryInterface;
use Equed\EquedLms\Domain\Service\QuizSubmissionServiceInterface;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Controller for presenting quizzes and processing submissions.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Interacts with domain models exclusively through repository and service interfaces.
 */
final class QuizController extends ActionController
{
    public function __construct(
        private readonly QuizRepositoryInterface            $quizRepository,
        private readonly QuestionRepositoryInterface        $questionRepository,
        private readonly QuizSubmissionServiceInterface     $quizSubmissionService,
        private readonly ConfigurationServiceInterface      $configurationService,
        private readonly GptTranslationServiceInterface     $translationService,
        private readonly Context                            $context
    ) {
        parent::__construct();
    }

    /**
     * Lists available quizzes for the authenticated user.
     *
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function listAction(): ResponseInterface
    {
        if (!$this->configurationService->isFeatureEnabled('quiz_module')) {
            $message = $this->translationService->translate('controller.quiz.list.disabled');
            $this->addFlashMessage($message, '', AbstractMessage::WARNING);
            $this->view->assign('quizzes', []);
            return $this->htmlResponse();
        }

        $user = $this->context->getAspect('frontend.user')->get('user');
        $userId = is_array($user) && isset($user['uid']) ? (int)$user['uid'] : 0;

        $quizzes = $this->quizRepository->findAvailableByUser($userId);

        $this->view->assignMultiple([
            'quizzes' => $quizzes,
        ]);

        return $this->htmlResponse();
    }

    /**
     * Displays a single quiz with its questions.
     *
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function showAction(): ResponseInterface
    {
        $quizId = (int)($this->request->getArgument('quiz') ?? 0);
        if ($quizId <= 0) {
            $message = $this->translationService->translate('controller.quiz.show.invalid');
            $this->addFlashMessage($message, '', AbstractMessage::ERROR);
            return $this->redirect('list');
        }

        $quiz = $this->quizRepository->findByUid($quizId);
        if ($quiz === null) {
            $message = $this->translationService->translate('controller.quiz.show.notFound');
            $this->addFlashMessage($message, '', AbstractMessage::ERROR);
            return $this->redirect('list');
        }

        $questions = $this->questionRepository->findByQuiz($quiz);

        $this->view->assignMultiple([
            'quiz' => $quiz,
            'questions' => $questions,
        ]);

        return $this->htmlResponse();
    }

    /**
     * Processes quiz submission and shows results.
     *
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function submitAction(): ResponseInterface
    {
        $quizId = (int)($this->request->getArgument('quiz') ?? 0);
        $answers = (array)($this->request->getArgument('answers') ?? []);
        $user = $this->context->getAspect('frontend.user')->get('user');
        $userId = is_array($user) && isset($user['uid']) ? (int)$user['uid'] : 0;

        $result = $this->quizSubmissionService->submitAnswers($quizId, $userId, $answers);

        $this->view->assignMultiple([
            'result' => $result,
        ]);

        $message = $this->translationService->translate(
            'controller.quiz.submit.processed',
            null,
            ['{score}' => (string)$result->getScore()]
        );
        $this->addFlashMessage($message);

        return $this->htmlResponse();
    }
}
// EOF
