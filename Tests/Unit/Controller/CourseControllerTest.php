<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Controller;

use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use Equed\EquedLms\Controller\CourseController;
use Equed\EquedLms\Service\CourseServiceInterface;
use TYPO3\CMS\Core\View\ViewInterface;
use Psr\Log\LoggerInterface;

final class CourseControllerTest extends TestCase
{
    use ProphecyTrait;

    private CourseController $subject;
    private $courseService;
    private $logger;
    private $view;

    protected function setUp(): void
    {
        $this->courseService = $this->prophesize(CourseServiceInterface::class);
        $this->logger = $this->prophesize(LoggerInterface::class);
        $this->view = $this->prophesize(ViewInterface::class);

        $this->subject = new CourseController(
            $this->courseService->reveal(),
            $this->logger->reveal()
        );
        $this->subject->injectView($this->view->reveal());
    }

    public function testListActionAssignsCoursesToView(): void
    {
        $courses = ['course1', 'course2'];
        $this->courseService->getAvailableCourses()->willReturn($courses);

        $this->view->assign('courses', $courses)->shouldBeCalled();

        $this->subject->listAction();
    }

    public function testShowActionAssignsSingleCourse(): void
    {
        $course = ['id' => 12];
        $this->courseService->getCourseById(12)->willReturn($course);

        $this->view->assign('course', $course)->shouldBeCalled();

        $this->subject->showAction(12);
    }

    public function testShowActionLogsMissingCourse(): void
    {
        $this->courseService->getCourseById(99)->willReturn(null);

        $this->logger->warning('Course not found.', ['id' => 99])->shouldBeCalled();

        $this->subject->showAction(99);
    }
}
