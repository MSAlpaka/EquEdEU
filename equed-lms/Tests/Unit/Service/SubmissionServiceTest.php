<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Domain\Repository\UserSubmissionRepositoryInterface;
use Equed\EquedLms\Service\SubmissionService;
use Equed\EquedLms\Domain\Service\ClockInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use Psr\EventDispatcher\EventDispatcherInterface;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use PHPUnit\Framework\TestCase;

class SubmissionServiceTest extends TestCase
{
    use ProphecyTrait;

    private SubmissionService $subject;
    private $repository;
    private $connectionPool;
    private $eventDispatcher;
    private $clock;

    protected function setUp(): void
    {
        $this->repository      = $this->prophesize(UserSubmissionRepositoryInterface::class);
        $this->connectionPool  = $this->prophesize(ConnectionPool::class);
        $this->eventDispatcher = $this->prophesize(EventDispatcherInterface::class);
        $this->clock           = $this->prophesize(ClockInterface::class);

        $this->subject = new SubmissionService(
            $this->repository->reveal(),
            $this->connectionPool->reveal(),
            $this->eventDispatcher->reveal(),
            $this->clock->reveal()
        );
    }

    public function testGetPendingSubmissionsDelegatesToRepository(): void
    {
        $expected = [];
        $this->repository->findPendingSubmissionsForInstructor(5)->willReturn($expected);

        $this->assertSame($expected, $this->subject->getPendingSubmissions(5));
    }

    public function testCountSubmissionsForCourseDelegates(): void
    {
        $this->repository->countByCourseInstance(3)->willReturn(2);

        $this->assertSame(2, $this->subject->countSubmissionsForCourse(3));
    }

    public function testGetAllForUserDelegates(): void
    {
        $expected = [1, 2];
        $this->repository->findByFeUser(9)->willReturn($expected);

        $this->assertSame($expected, $this->subject->getAllForUser(9));
    }
}
