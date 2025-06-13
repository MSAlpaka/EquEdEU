<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Service\CourseCompletionService;
use Equed\EquedLms\Domain\Repository\UserCourseRecordRepositoryInterface;
use Equed\EquedLms\Factory\UserCourseRecordFactoryInterface;
use Equed\EquedLms\Domain\Service\ClockInterface;
use Equed\EquedLms\Event\Course\CourseCompletedEvent;
use Equed\EquedLms\Domain\Model\UserCourseRecord;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use DateTimeImmutable;
use Prophecy\Argument;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;

if (!interface_exists(PersistenceManagerInterface::class)) {
    interface PersistenceManagerInterface { public function persistAll(); }
}

final class CourseCompletionServiceTest extends TestCase
{
    use ProphecyTrait;

    private CourseCompletionService $subject;
    private $repo;
    private $factory;
    private $pm;
    private $dispatcher;
    private $clock;

    protected function setUp(): void
    {
        $this->repo = $this->prophesize(UserCourseRecordRepositoryInterface::class);
        $this->factory = $this->prophesize(UserCourseRecordFactoryInterface::class);
        $this->pm = $this->prophesize(PersistenceManagerInterface::class);
        $this->dispatcher = $this->prophesize(EventDispatcherInterface::class);
        $this->clock = $this->prophesize(ClockInterface::class);

        $this->subject = new CourseCompletionService(
            $this->repo->reveal(),
            $this->factory->reveal(),
            $this->pm->reveal(),
            $this->dispatcher->reveal(),
            $this->clock->reveal(),
        );
    }

    public function testMarksCompletedAndDispatchesEventWhenRecordMissing(): void
    {
        $record = $this->prophesize(UserCourseRecord::class);
        $record->isCompleted()->willReturn(false);
        $record->setCompleted(true)->shouldBeCalled();
        $now = new DateTimeImmutable('2024-01-01 00:00:00');
        $record->setCompletedAt($now)->shouldBeCalled();

        $this->repo->findOneByUserAndCourse(3, 7)->willReturn(null);
        $this->factory->createForUserAndCourse(3, 7)->willReturn($record->reveal());
        $this->repo->add($record->reveal())->shouldBeCalled();
        $this->pm->persistAll()->shouldBeCalled();
        $this->clock->now()->willReturn($now);
        $this->dispatcher->dispatch(Argument::type(CourseCompletedEvent::class))->shouldBeCalled();

        $result = $this->subject->markCompletedIfNotYet(3, 7);
        $this->assertTrue($result);
    }

    public function testReturnsFalseIfAlreadyCompleted(): void
    {
        $record = $this->prophesize(UserCourseRecord::class);
        $record->isCompleted()->willReturn(true);
        $record->setCompleted(Argument::any())->shouldNotBeCalled();

        $this->repo->findOneByUserAndCourse(5, 9)->willReturn($record->reveal());
        $this->pm->persistAll()->shouldNotBeCalled();
        $this->dispatcher->dispatch(Argument::cetera())->shouldNotBeCalled();

        $result = $this->subject->markCompletedIfNotYet(5, 9);
        $this->assertFalse($result);
    }
}
