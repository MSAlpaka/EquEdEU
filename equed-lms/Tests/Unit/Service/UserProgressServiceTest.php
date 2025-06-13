<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Service\UserProgressService;
use Equed\EquedLms\Domain\Repository\LessonRepositoryInterface;
use Equed\EquedLms\Domain\Repository\UserSubmissionRepositoryInterface;
use Equed\EquedLms\Domain\Model\Lesson;
use Equed\EquedLms\Domain\Model\UserCourseRecord;
use Equed\EquedLms\Dto\UserProgress;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;

final class UserProgressServiceTest extends TestCase
{
    use ProphecyTrait;

    private UserProgressService $subject;
    private $lessonRepo;
    private $submissionRepo;

    protected function setUp(): void
    {
        $this->lessonRepo = $this->prophesize(LessonRepositoryInterface::class);
        $this->submissionRepo = $this->prophesize(UserSubmissionRepositoryInterface::class);
        $this->subject = new UserProgressService(
            $this->lessonRepo->reveal(),
            $this->submissionRepo->reveal()
        );
    }

    public function testCalculateReturnsZeroWhenNoProgram(): void
    {
        $ucr = new UserCourseRecord();
        $result = $this->subject->calculate($ucr);
        $this->assertEquals(new UserProgress(0, 0, 0), $result);
    }

    public function testCalculateComputesPercentages(): void
    {
        $lesson1 = new Lesson();
        $lesson2 = new Lesson();

        $program = new class { public function getUid() { return 2; } };
        $instance = new class($program) { private $p; public function __construct($p){$this->p=$p;} public function getCourseProgram(){ return $this->p; } };
        $ucr = new UserCourseRecord();
        $ucr->_setProperty('courseInstance', $instance);
        $ucr->setQuizScorePercent(50);
        $ucr->setCompletedLessons([$lesson1]);

        $this->lessonRepo->findRequiredByCourseProgram(2)->willReturn([$lesson1, $lesson2]);
        $this->submissionRepo->findScoresByUserCourseRecord(Argument::cetera())->willReturn([
            ['points' => 5, 'maxPoints' => 10],
        ]);

        $result = $this->subject->calculate($ucr);
        $this->assertSame(60, $result->percent);
        $this->assertSame(1, $result->completedLessons);
        $this->assertSame(2, $result->totalLessons);
    }
}
