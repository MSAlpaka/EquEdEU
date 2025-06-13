<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Service\CourseGoalService;
use Equed\EquedLms\Domain\Repository\CourseGoalRepositoryInterface;
use Equed\EquedLms\Domain\Model\CourseGoal;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;

final class CourseGoalServiceTest extends TestCase
{
    use ProphecyTrait;

    private CourseGoalService $subject;
    private $repo;

    protected function setUp(): void
    {
        $this->repo = $this->prophesize(CourseGoalRepositoryInterface::class);
        $this->subject = new CourseGoalService(
            $this->repo->reveal()
        );
    }

    public function testGoalsAreCachedPerProgram(): void
    {
        $goal = new CourseGoal();
        $this->repo->findByCourseProgram(3)->willReturn([$goal])->shouldBeCalledTimes(1);

        $first = $this->subject->getGoalsForCourseProgram(3);
        $second = $this->subject->getGoalsForCourseProgram(3);

        $this->assertSame([$goal], $first);
        $this->assertSame([$goal], $second);
    }

    public function testIsGoalMetChecksProgressItems(): void
    {
        $goal = new CourseGoal();
        $goal->_setProperty('uid', 5);

        $lesson = new class($goal) {
            private CourseGoal $goal; public function __construct($g) { $this->goal = $g; }
            public function getCourseGoal(): CourseGoal { return $this->goal; }
        };

        $progress = new class($lesson) {
            private $lesson; public function __construct($l) { $this->lesson = $l; }
            public function getLesson() { return $this->lesson; }
            public function getStatus() { return 'completed'; }
        };

        $this->assertTrue($this->subject->isGoalMet([$progress], 5));
        $this->assertFalse($this->subject->isGoalMet([$progress], 6));
    }
}
