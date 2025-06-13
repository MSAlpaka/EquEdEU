<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Domain\Repository\LessonRepositoryInterface;
use Equed\EquedLms\Domain\Model\Lesson;
use Equed\EquedLms\Service\LessonContentService;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use PHPUnit\Framework\TestCase;

final class LessonContentServiceTest extends TestCase
{
    use ProphecyTrait;

    private LessonContentService $subject;
    private $repo;

    protected function setUp(): void
    {
        $this->repo = $this->prophesize(LessonRepositoryInterface::class);
        $this->subject = new LessonContentService(
            $this->repo->reveal()
        );
    }

    public function testReturnsOnlyVisibleLessonsForProgram(): void
    {
        $visible = $this->prophesize(Lesson::class);
        $visible->getHidden()->willReturn(false);
        $hidden = $this->prophesize(Lesson::class);
        $hidden->getHidden()->willReturn(true);

        $this->repo->findByCourseProgram(11)->willReturn([
            $visible->reveal(),
            $hidden->reveal(),
        ]);

        $result = $this->subject->getVisibleLessonsForCourseProgram(11);
        $this->assertSame([$visible->reveal()], $result);
    }
}
