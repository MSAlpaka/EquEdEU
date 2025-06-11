<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Equed\EquedLms\Service\LessonProgressService;
use Equed\EquedLms\Domain\Repository\LessonProgressRepositoryInterface;
use Equed\EquedLms\Domain\Model\LessonProgress;
use Equed\EquedLms\Domain\Model\Lesson;
use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;

class LessonProgressServiceTest extends TestCase
{
    use ProphecyTrait;

    private LessonProgressService $subject;
    private $repo;

    protected function setUp(): void
    {
        $this->repo = $this->prophesize(LessonProgressRepositoryInterface::class);
        $this->subject = new LessonProgressService($this->repo->reveal());
    }

    public function testSetProgressCompletedCreatesNewEntry(): void
    {
        $user = $this->prophesize(FrontendUser::class);
        $user->getUid()->willReturn(1);
        $lesson = $this->prophesize(Lesson::class);
        $lesson->getUid()->willReturn(2);

        $this->repo->findByUserAndLesson(1, 2)->willReturn(null);
        $this->repo->updateOrAdd(\Prophecy\Argument::type(LessonProgress::class))->shouldBeCalled();

        $progress = $this->subject->setProgressCompleted($user->reveal(), $lesson->reveal());
        $this->assertSame('completed', $progress->getStatus());
        $this->assertTrue($progress->isCompleted());
    }
}
