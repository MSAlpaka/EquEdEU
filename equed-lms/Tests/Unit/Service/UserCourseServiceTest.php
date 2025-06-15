<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Service\UserCourseService;
use Equed\EquedLms\Domain\Repository\UserCourseRecordRepositoryInterface;
use Equed\EquedLms\Domain\Model\UserCourseRecord;
use Equed\EquedLms\Enum\UserCourseStatus;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;

final class UserCourseServiceTest extends TestCase
{
    use ProphecyTrait;

    private UserCourseService $subject;
    private $repo;

    protected function setUp(): void
    {
        $this->repo = $this->prophesize(UserCourseRecordRepositoryInterface::class);
        $this->subject = new UserCourseService(
            $this->repo->reveal()
        );
    }

    public function testIsCourseActiveChecksRepository(): void
    {
        $this->repo->countByUserAndInstanceAndStatus(5, 10, UserCourseStatus::InProgress)->willReturn(1);
        $this->assertTrue($this->subject->isCourseActive(5, 10));

        $this->repo->countByUserAndInstanceAndStatus(5, 10, UserCourseStatus::InProgress)->willReturn(0);
        $this->assertFalse($this->subject->isCourseActive(5, 10));
    }

    public function testGetCurrentCoursesDelegatesToRepository(): void
    {
        $record = new UserCourseRecord();
        $this->repo->findByUserAndStatus(7, UserCourseStatus::InProgress)->willReturn([$record]);
        $this->assertSame([$record], $this->subject->getCurrentCourses(7));
    }

    public function testGetCompletedCoursesDelegatesToRepository(): void
    {
        $record = new UserCourseRecord();
        $this->repo->findByUserAndStatus(8, UserCourseStatus::Passed)->willReturn([$record]);
        $this->assertSame([$record], $this->subject->getCompletedCourses(8));
    }
}
