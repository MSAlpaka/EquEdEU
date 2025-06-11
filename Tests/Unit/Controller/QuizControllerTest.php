<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Controller;

use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use Equed\EquedLms\Controller\QuizController;
use Equed\EquedLms\Service\QuizServiceInterface;
use TYPO3\CMS\Core\View\ViewInterface;
use Psr\Log\LoggerInterface;

final class QuizControllerTest extends TestCase
{
    use ProphecyTrait;

    private QuizController $subject;
    private $quizService;
    private $logger;
    private $view;

    protected function setUp(): void
    {
        $this->quizService = $this->prophesize(QuizServiceInterface::class);
        $this->logger = $this->prophesize(LoggerInterface::class);
        $this->view = $this->prophesize(ViewInterface::class);

        $this->subject = new QuizController(
            $this->quizService->reveal(),
            $this->logger->reveal()
        );
        $this->subject->injectView($this->view->reveal());
    }

    public function testListActionAssignsQuiz(): void
    {
        $quizzes = ['q1', 'q2'];
        $this->quizService->getAvailable()->willReturn($quizzes);

        $this->view->assign('quizzes', $quizzes)->shouldBeCalled();

        $this->subject->listAction();
    }

    public function testStartActionAssignsQuiz(): void
    {
        $quiz = ['id' => 9];
        $this->quizService->getById(9)->willReturn($quiz);

        $this->view->assign('quiz', $quiz)->shouldBeCalled();

        $this->subject->startAction(9);
    }

    public function testStartActionLogsMissing(): void
    {
        $this->quizService->getById(404)->willReturn(null);
        $this->logger->warning('Quiz not found.', ['id' => 404])->shouldBeCalled();

        $this->subject->startAction(404);
    }
}
