<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Equed\EquedLms\Service\LessonProgressService;
use Equed\EquedLms\Domain\Repository\LessonProgressRepositoryInterface;
use Equed\EquedLms\Domain\Repository\LessonRepositoryInterface;
use Equed\EquedLms\Domain\Service\ClockInterface;
use Equed\EquedLms\Domain\Model\LessonProgress;
use Equed\EquedLms\Domain\Model\Lesson;
use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;
use Equed\EquedLms\Enum\ProgressStatus;

class LessonProgressServiceTest extends TestCase
{
    use ProphecyTrait;

    private LessonProgressService $subject;
    private $repo;
    private $lessonRepo;
    private $clock;

    protected function setUp(): void
    {
        $this->repo = $this->prophesize(LessonProgressRepositoryInterface::class);
        $this->lessonRepo = $this->prophesize(LessonRepositoryInterface::class);
        $this->clock = $this->prophesize(ClockInterface::class);

        $this->subject = new LessonProgressService(
            $this->repo->reveal(),
            $this->lessonRepo->reveal(),
            $this->clock->reveal(),
        );
    }

    public function testSetProgressCompletedCreatesNewEntry(): void
    {
        $user = $this->prophesize(FrontendUser::class);
        $user->getUid()->willReturn(1);
        $lesson = $this->prophesize(Lesson::class);
        $lesson->getUid()->willReturn(2);

        $this->repo->findByUserAndLesson(1, 2)->willReturn(null);
        $this->lessonRepo->findByUid(2)->willReturn($lesson->reveal());
        $this->clock->now()->willReturn(new \DateTimeImmutable('2024-01-01 00:00:00'));
        $this->repo->updateOrAdd(\Prophecy\Argument::type(LessonProgress::class))->shouldBeCalled();

        $progress = $this->subject->setProgress(1, 2, true);
        $this->assertSame(ProgressStatus::Completed, $progress->getStatus());
        $this->assertTrue($progress->isCompleted());
    }
}
