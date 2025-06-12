<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Domain\Model\CourseInstance;
use Equed\EquedLms\Domain\Model\CourseProgram;
use Equed\EquedLms\Domain\Model\Lesson;
use Equed\EquedLms\Domain\Model\UserCourseRecord;
use Equed\EquedLms\Domain\Repository\UserCourseRecordRepository;
use Equed\EquedLms\Service\CourseAccessService;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use PHPUnit\Framework\TestCase;

class CourseAccessServiceTest extends TestCase
{
    use ProphecyTrait;

    private CourseAccessService $subject;
    private $repository;

    protected function setUp(): void
    {
        $this->repository = $this->prophesize(UserCourseRecordRepository::class);
        $this->subject = new CourseAccessService($this->repository->reveal());
    }

    public function testHasAccessToCourseInstanceReturnsTrue(): void
    {
        $instance = new CourseInstance();
        $instance->_setProperty('uid', 7);
        $record = new UserCourseRecord();
        $record->setCourseInstance($instance);

        $this->repository->findByFeUser(5)->willReturn([$record]);

        $this->assertTrue($this->subject->hasAccessToCourseInstance(5, 7));
    }

    public function testIsLessonUnlockedForUserChecksCourseProgram(): void
    {
        $program = new CourseProgram();
        $program->_setProperty('uid', 3);

        $instance = new CourseInstance();
        $instance->setCourseProgram($program);
        $record = new UserCourseRecord();
        $record->setCourseInstance($instance);

        $this->repository->findByFeUser(2)->willReturn([$record]);

        $lesson = $this->prophesize(Lesson::class);
        $lesson->getCourseProgram()->willReturn($program);

        $this->assertTrue($this->subject->isLessonUnlockedForUser(2, $lesson->reveal()));
    }

    public function testRepositoryCalledOnlyOnceForSameUser(): void
    {
        $this->repository->findByFeUser(1)->willReturn([])->shouldBeCalledTimes(1);

        $this->subject->hasAccessToCourseInstance(1, 10);
        $this->subject->hasAccessToCourseInstance(1, 11);
    }
}
