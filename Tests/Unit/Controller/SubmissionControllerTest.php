<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Controller;

use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use Equed\EquedLms\Controller\SubmissionController;
use Equed\EquedLms\Service\SubmissionServiceInterface;
use TYPO3\CMS\Core\View\ViewInterface;
use Psr\Log\LoggerInterface;

final class SubmissionControllerTest extends TestCase
{
    use ProphecyTrait;

    private SubmissionController $subject;
    private $submissionService;
    private $logger;
    private $view;

    protected function setUp(): void
    {
        $this->submissionService = $this->prophesize(SubmissionServiceInterface::class);
        $this->logger = $this->prophesize(LoggerInterface::class);
        $this->view = $this->prophesize(ViewInterface::class);

        $this->subject = new SubmissionController(
            $this->submissionService->reveal(),
            $this->logger->reveal()
        );
        $this->subject->injectView($this->view->reveal());
    }

    public function testListActionAssignsSubmissions(): void
    {
        $subs = ['sub1', 'sub2'];
        $this->submissionService->getAllForUser()->willReturn($subs);

        $this->view->assign('submissions', $subs)->shouldBeCalled();

        $this->subject->listAction();
    }

    public function testShowActionAssignsSubmission(): void
    {
        $submission = ['id' => 42];
        $this->submissionService->getById(42)->willReturn($submission);

        $this->view->assign('submission', $submission)->shouldBeCalled();

        $this->subject->showAction(42);
    }

    public function testShowActionLogsWhenNotFound(): void
    {
        $this->submissionService->getById(999)->willReturn(null);
        $this->logger->warning('Submission not found.', ['id' => 999])->shouldBeCalled();

        $this->subject->showAction(999);
    }
}
