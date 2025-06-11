<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Controller;

use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use Equed\EquedLms\Controller\FeedbackController;
use Equed\EquedLms\Service\FeedbackServiceInterface;
use TYPO3\CMS\Core\View\ViewInterface;
use Psr\Log\LoggerInterface;

final class FeedbackControllerTest extends TestCase
{
    use ProphecyTrait;

    private FeedbackController $subject;
    private $feedbackService;
    private $logger;
    private $view;

    protected function setUp(): void
    {
        $this->feedbackService = $this->prophesize(FeedbackServiceInterface::class);
        $this->logger = $this->prophesize(LoggerInterface::class);
        $this->view = $this->prophesize(ViewInterface::class);

        $this->subject = new FeedbackController(
            $this->feedbackService->reveal(),
            $this->logger->reveal()
        );
        $this->subject->injectView($this->view->reveal());
    }

    public function testShowActionAssignsFeedback(): void
    {
        $feedback = ['rating' => 5, 'comment' => 'Great course'];
        $this->feedbackService->getForCourse(10)->willReturn($feedback);

        $this->view->assign('feedback', $feedback)->shouldBeCalled();

        $this->subject->showAction(10);
    }

    public function testShowActionLogsMissingFeedback(): void
    {
        $this->feedbackService->getForCourse(999)->willReturn(null);
        $this->logger->notice('No feedback found for course.', ['id' => 999])->shouldBeCalled();

        $this->subject->showAction(999);
    }
}
