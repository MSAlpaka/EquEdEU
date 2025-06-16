<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Controller;

use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use Equed\EquedLms\Controller\InstructorController;
use Equed\EquedLms\Domain\Service\InstructorServiceInterface;
use TYPO3\CMS\Core\View\ViewInterface;
use Psr\Log\LoggerInterface;

final class InstructorControllerTest extends TestCase
{
    use ProphecyTrait;

    private InstructorController $subject;
    private $instructorService;
    private $logger;
    private $view;

    protected function setUp(): void
    {
        $this->instructorService = $this->prophesize(InstructorServiceInterface::class);
        $this->logger = $this->prophesize(LoggerInterface::class);
        $this->view = $this->prophesize(ViewInterface::class);

        $this->subject = new InstructorController(
            $this->instructorService->reveal(),
            $this->logger->reveal()
        );
        $this->subject->injectView($this->view->reveal());
    }

    public function testListActionAssignsInstructors(): void
    {
        $instructors = ['inst1', 'inst2'];
        $this->instructorService->getAllActive()->willReturn($instructors);

        $this->view->assign('instructors', $instructors)->shouldBeCalled();

        $this->subject->listAction();
    }

    public function testShowActionAssignsInstructor(): void
    {
        $inst = ['id' => 21];
        $this->instructorService->getById(21)->willReturn($inst);

        $this->view->assign('instructor', $inst)->shouldBeCalled();

        $this->subject->showAction(21);
    }

    public function testShowActionLogsMissingInstructor(): void
    {
        $this->instructorService->getById(999)->willReturn(null);
        $this->logger->notice('Instructor not found.', ['id' => 999])->shouldBeCalled();

        $this->subject->showAction(999);
    }
}
