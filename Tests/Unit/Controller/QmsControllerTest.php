<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Controller;

use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use Equed\EquedLms\Controller\QmsController;
use Equed\EquedLms\Service\QmsCaseServiceInterface;
use TYPO3\CMS\Core\View\ViewInterface;
use Psr\Log\LoggerInterface;

final class QmsControllerTest extends TestCase
{
    use ProphecyTrait;

    private QmsController $subject;
    private $qmsService;
    private $logger;
    private $view;

    protected function setUp(): void
    {
        $this->qmsService = $this->prophesize(QmsCaseServiceInterface::class);
        $this->logger = $this->prophesize(LoggerInterface::class);
        $this->view = $this->prophesize(ViewInterface::class);

        $this->subject = new QmsController(
            $this->qmsService->reveal(),
            $this->logger->reveal()
        );
        $this->subject->injectView($this->view->reveal());
    }

    public function testListActionAssignsCases(): void
    {
        $cases = ['case1', 'case2'];
        $this->qmsService->getAllCases()->willReturn($cases);

        $this->view->assign('cases', $cases)->shouldBeCalled();

        $this->subject->listAction();
    }

    public function testDetailActionAssignsCase(): void
    {
        $case = ['id' => 77];
        $this->qmsService->getCaseById(77)->willReturn($case);

        $this->view->assign('case', $case)->shouldBeCalled();

        $this->subject->detailAction(77);
    }

    public function testDetailActionLogsWhenNotFound(): void
    {
        $this->qmsService->getCaseById(999)->willReturn(null);
        $this->logger->warning('QMS case not found.', ['id' => 999])->shouldBeCalled();

        $this->subject->detailAction(999);
    }
}
