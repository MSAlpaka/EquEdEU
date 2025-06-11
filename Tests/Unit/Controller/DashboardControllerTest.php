<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Controller;

use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use Equed\EquedLms\Controller\DashboardController;
use Equed\EquedLms\Service\DashboardServiceInterface;
use TYPO3\CMS\Core\View\ViewInterface;
use Psr\Log\LoggerInterface;

final class DashboardControllerTest extends TestCase
{
    use ProphecyTrait;

    private DashboardController $subject;
    private $dashboardService;
    private $logger;
    private $view;

    protected function setUp(): void
    {
        $this->dashboardService = $this->prophesize(DashboardServiceInterface::class);
        $this->logger = $this->prophesize(LoggerInterface::class);
        $this->view = $this->prophesize(ViewInterface::class);

        $this->subject = new DashboardController(
            $this->dashboardService->reveal(),
            $this->logger->reveal()
        );
        $this->subject->injectView($this->view->reveal());
    }

    public function testOverviewAssignsDashboardData(): void
    {
        $data = ['courses' => 2, 'certifications' => 1];
        $this->dashboardService->getUserDashboardData()->willReturn($data);

        $this->view->assign('dashboard', $data)->shouldBeCalled();

        $this->subject->overviewAction();
    }

    public function testOverviewHandlesMissingData(): void
    {
        $this->dashboardService->getUserDashboardData()->willReturn(null);
        $this->logger->notice('No dashboard data available for user')->shouldBeCalled();

        $this->subject->overviewAction();
    }
}
