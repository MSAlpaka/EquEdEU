<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Service\CourseProgressService;
use Equed\EquedLms\Service\CourseProgressServiceInterface;
use Equed\EquedLms\Dto\CourseViewModel;
use Equed\EquedLms\Domain\Repository\CourseRepositoryInterface;
use Equed\EquedLms\Domain\Repository\LessonProgressRepositoryInterface;
use Equed\EquedLms\Domain\Service\CourseCompletionServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Model\Course;
use Equed\EquedLms\Domain\Model\Lesson;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;

final class CourseProgressServiceTest extends TestCase
{
    use ProphecyTrait;

    private CourseProgressServiceInterface $subject;
    private $courseRepo;
    private $progressRepo;
    private $completion;
    private $translator;

    protected function setUp(): void
    {
        $this->courseRepo = $this->prophesize(CourseRepositoryInterface::class);
        $this->progressRepo = $this->prophesize(LessonProgressRepositoryInterface::class);
        $this->completion = $this->prophesize(CourseCompletionServiceInterface::class);
        $this->translator = $this->prophesize(GptTranslationServiceInterface::class);

        $this->subject = new CourseProgressService(
            $this->courseRepo->reveal(),
            $this->progressRepo->reveal(),
            $this->completion->reveal(),
            $this->translator->reveal(),
        );
    }

    public function testReturnsErrorWhenCourseMissing(): void
    {
        $this->translator->translate('error.courseNotFound')->willReturn('err');
        $this->courseRepo->findByUid(5)->willReturn(null);

        $result = $this->subject->getCourseViewModel(5, 3);
        $this->assertInstanceOf(CourseViewModel::class, $result);
        $this->assertTrue($result->hasError());
        $this->assertSame('err', $result->getError());
    }

    public function testCalculatesProgressAndMarksCompletion(): void
    {
        $course = $this->prophesize(Course::class);
        $lesson = $this->prophesize(Lesson::class);
        $lessons = new ObjectStorage();
        $lessons->attach($lesson->reveal());
        $course->getLessons()->willReturn($lessons);

        $this->courseRepo->findByUid(7)->willReturn($course->reveal());
        $this->progressRepo->countCompletedByUserAndLessons(3, [$lesson->reveal()])->willReturn(1);
        $this->completion->markCompletedIfNotYet(3, 7)->shouldBeCalled();

        $result = $this->subject->getCourseViewModel(7, 3);
        $this->assertInstanceOf(CourseViewModel::class, $result);
        $this->assertFalse($result->hasError());
        $this->assertSame(100, $result->getProgress());
        $this->assertSame($course->reveal(), $result->getCourse());
    }
}
