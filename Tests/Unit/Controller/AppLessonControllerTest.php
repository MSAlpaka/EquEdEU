<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Controller;

use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use Equed\EquedLms\Controller\AppLessonController;
use Equed\EquedLms\Service\LessonServiceInterface;
use Psr\Log\LoggerInterface;
use TYPO3\CMS\Core\View\ViewInterface;

final class AppLessonControllerTest extends TestCase
{
    use ProphecyTrait;

    private AppLessonController $subject;
    private $lessonService;
    private $logger;
    private $view;

    protected function setUp(): void
    {
        $this->lessonService = $this->prophesize(LessonServiceInterface::class);
        $this->logger = $this->prophesize(LoggerInterface::class);
        $this->view = $this->prophesize(ViewInterface::class);

        $this->subject = new AppLessonController(
            $this->lessonService->reveal(),
            $this->logger->reveal()
        );
        $this->subject->injectView($this->view->reveal());
    }

    public function testListActionAssignsLessonsToView(): void
    {
        $dummyLessons = ['lesson1', 'lesson2'];
        $this->lessonService->getAllForCurrentUser()->willReturn($dummyLessons);

        $this->view->assign('lessons', $dummyLessons)->shouldBeCalled();

        $this->subject->listAction();
    }

    public function testShowActionLogsMissingLesson(): void
    {
        $this->lessonService->findById(42)->willReturn(null);

        $this->logger->warning('Lesson not found.', ['id' => 42])->shouldBeCalled();

        $this->subject->showAction(42);
    }
}
