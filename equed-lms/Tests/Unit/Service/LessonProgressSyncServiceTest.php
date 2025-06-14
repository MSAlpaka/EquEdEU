<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Domain\Model\LessonProgress;
use Equed\EquedLms\Domain\Model\Lesson;
use Equed\EquedLms\Enum\ProgressStatus;
use Equed\EquedLms\Domain\Repository\LessonProgressRepositoryInterface;
use Equed\EquedLms\Domain\Repository\LessonRepositoryInterface;
use Equed\EquedLms\Service\LessonProgressSyncService;
use Equed\EquedLms\Domain\Service\ClockInterface;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;

class LessonProgressSyncServiceTest extends TestCase
{
    use ProphecyTrait;

    private LessonProgressSyncService $subject;
    private $progressRepo;
    private $lessonRepo;
    private $pm;
    private $clock;

    protected function setUp(): void
    {
        $this->progressRepo = $this->prophesize(LessonProgressRepositoryInterface::class);
        $this->lessonRepo = $this->prophesize(LessonRepositoryInterface::class);
        $this->pm = $this->prophesize(PersistenceManagerInterface::class);
        $this->clock = $this->prophesize(ClockInterface::class);
        $this->subject = new LessonProgressSyncService(
            $this->progressRepo->reveal(),
            $this->lessonRepo->reveal(),
            $this->pm->reveal(),
            $this->clock->reveal()
        );
    }

    public function testExportForAppFormatsProgress(): void
    {
        $lesson = $this->prophesize(Lesson::class);
        $lesson->getUid()->willReturn(4);

        $progress = $this->prophesize(LessonProgress::class);
        $progress->getLesson()->willReturn($lesson->reveal());
        $progress->getProgress()->willReturn(50);
        $progress->getStatus()->willReturn(ProgressStatus::InProgress);
        $progress->isCompleted()->willReturn(false);
        $progress->getUpdatedAt()->willReturn(new \DateTimeImmutable('2024-01-01T10:00:00+00:00'));

        $this->progressRepo->findByUserId(1)->willReturn([$progress->reveal()]);

        $result = $this->subject->exportForApp(1);

        $this->assertSame([
            [
                'lessonId' => 4,
                'progress' => 50,
                'status' => 'inProgress',
                'completed' => false,
                'updatedAt' => '2024-01-01T10:00:00+00:00',
            ],
        ], $result);
    }

    public function testSyncFromAppSkipsWhenOlder(): void
    {
        $lesson = $this->prophesize(Lesson::class);
        $lesson->getUid()->willReturn(5);
        $this->lessonRepo->findByUid(5)->willReturn($lesson->reveal());

        $existing = $this->prophesize(LessonProgress::class);
        $existing->getUpdatedAt()->willReturn(new \DateTimeImmutable('2024-01-02T00:00:00+00:00'));

        $existing->setFeUser()->shouldNotBeCalled();
        $existing->setLesson()->shouldNotBeCalled();
        $existing->setProgress()->shouldNotBeCalled();
        $existing->setStatus()->shouldNotBeCalled();
        $existing->setCompleted()->shouldNotBeCalled();
        $existing->setUpdatedAt()->shouldNotBeCalled();

        $this->progressRepo->findByUserAndLesson(1, 5)->willReturn($existing->reveal());
        $this->progressRepo->updateOrAdd($existing->reveal())->shouldBeCalled();
        $this->pm->persistAll()->shouldBeCalled();

        $this->subject->syncFromApp([
            [
                'lessonId' => 5,
                'progress' => 20,
                'status' => 'inProgress',
                'completed' => false,
                'updatedAt' => '2024-01-01T00:00:00+00:00',
            ]
        ], 1);
    }

    public function testSyncFromAppUpdatesWhenNewer(): void
    {
        $lesson = $this->prophesize(Lesson::class);
        $lesson->getUid()->willReturn(6);
        $this->lessonRepo->findByUid(6)->willReturn($lesson->reveal());

        $existing = $this->prophesize(LessonProgress::class);
        $existing->getUpdatedAt()->willReturn(new \DateTimeImmutable('2024-01-01T00:00:00+00:00'));

        $existing->setFeUser(2)->shouldBeCalled();
        $existing->setLesson($lesson->reveal())->shouldBeCalled();
        $existing->setProgress(80)->shouldBeCalled();
        $existing->setStatus(ProgressStatus::Completed)->shouldBeCalled();
        $existing->setCompleted(true)->shouldBeCalled();
        $this->clock->now()->willReturn(new \DateTimeImmutable('2024-02-01T00:00:00+00:00'));
        $existing->setUpdatedAt(new \DateTimeImmutable('2024-02-01T00:00:00+00:00'))->shouldBeCalled();

        $this->progressRepo->findByUserAndLesson(2, 6)->willReturn($existing->reveal());
        $this->progressRepo->updateOrAdd($existing->reveal())->shouldBeCalled();
        $this->pm->persistAll()->shouldBeCalled();

        $this->subject->syncFromApp([
            [
                'lessonId' => 6,
                'progress' => 80,
                'status' => 'completed',
                'completed' => true,
                'updatedAt' => '2024-01-02T00:00:00+00:00',
            ]
        ], 2);
    }
}
