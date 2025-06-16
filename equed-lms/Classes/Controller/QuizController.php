<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller;

use Equed\EquedLms\Service\QuizManagerInterface;
use Equed\EquedLms\Dto\QuizSubmissionRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
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
        private readonly QuizManagerInterface $quizManager
    ) {
    }

    /**
     * Lists available quizzes for the authenticated user.
     *
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function listAction(ServerRequestInterface $request): ResponseInterface
    {
        $user = $request->getAttribute('user');
        $userId = is_array($user) && isset($user['uid']) ? (int)$user['uid'] : 0;

        $data = $this->quizManager->listQuizzes($userId);

        if ($data->hasMessage()) {
            $this->addFlashMessage(
                $data->getMessage(),
                '',
                $data->getSeverity()
            );
        }

        $this->view->assign('quizzes', $data->getQuizzes());

        return $this->htmlResponse();
    }

    /**
     * Displays a single quiz with its questions.
     *
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function showAction(ServerRequestInterface $request): ResponseInterface
    {
        $quizId = (int)($request->getQueryParams()['quiz'] ?? $request->getParsedBody()['quiz'] ?? 0);

        $data = $this->quizManager->getQuiz($quizId);

        if ($data->hasError()) {
            $this->addFlashMessage($data->getError(), '', AbstractMessage::ERROR);
            return $this->redirect('list');
        }

        $this->view->assignMultiple([
            'quiz' => $data->getQuiz(),
            'questions' => $data->getQuestions(),
        ]);

        return $this->htmlResponse();
    }

    /**
     * Processes quiz submission and shows results.
     *
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function submitAction(ServerRequestInterface $request): ResponseInterface
    {
        $quizId = (int)($request->getParsedBody()['quiz'] ?? 0);
        $answers = (array)($request->getParsedBody()['answers'] ?? []);
        $user = $request->getAttribute('user');
        $userId = is_array($user) && isset($user['uid']) ? (int)$user['uid'] : 0;

        $dto = new QuizSubmissionRequest($quizId, $userId, $answers);
        $data = $this->quizManager->submit($dto);

        $this->view->assign('result', $data->getResult());

        $this->addFlashMessage(
            $data->getMessage(),
            '',
            $data->getSeverity()
        );

        return $this->htmlResponse();
    }
}
