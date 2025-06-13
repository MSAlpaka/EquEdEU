<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Domain\Repository\LessonAttemptRepositoryInterface;
use Equed\EquedLms\Domain\Model\LessonAttempt;
use Equed\EquedLms\Service\LessonAttemptService;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use PHPUnit\Framework\TestCase;

final class LessonAttemptServiceTest extends TestCase
{
    use ProphecyTrait;

    private LessonAttemptService $subject;
    private $repo;

    protected function setUp(): void
    {
        $this->repo = $this->prophesize(LessonAttemptRepositoryInterface::class);
        $this->subject = new LessonAttemptService(
            $this->repo->reveal()
        );
    }

    public function testGetLatestAttemptForLessonReturnsRepositoryResult(): void
    {
        $attempt = $this->prophesize(LessonAttempt::class);
        $this->repo->findLatestByUserAndLesson(5, 7)->willReturn($attempt->reveal());

        $result = $this->subject->getLatestAttemptForLesson(5, 7);
        $this->assertSame($attempt->reveal(), $result);
    }

    public function testHasUnfinishedAttemptReturnsTrue(): void
    {
        $attempt = $this->prophesize(LessonAttempt::class);
        $attempt->getStatus()->willReturn('incomplete');
        $this->repo->findLatestByUserAndLesson(3, 9)->willReturn($attempt->reveal());

        $this->assertTrue($this->subject->hasUnfinishedAttempt(3, 9));
    }

    public function testHasUnfinishedAttemptReturnsFalseWhenCompleted(): void
    {
        $attempt = $this->prophesize(LessonAttempt::class);
        $attempt->getStatus()->willReturn('completed');
        $this->repo->findLatestByUserAndLesson(2, 4)->willReturn($attempt->reveal());

        $this->assertFalse($this->subject->hasUnfinishedAttempt(2, 4));
    }

    public function testHasUnfinishedAttemptReturnsFalseWhenNoAttempts(): void
    {
        $this->repo->findLatestByUserAndLesson(1, 8)->willReturn(null);

        $this->assertFalse($this->subject->hasUnfinishedAttempt(1, 8));
    }
}
