<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Domain\Repository\UserSubmissionRepositoryInterface;
use Equed\EquedLms\Service\SubmissionService;
use Equed\EquedLms\Dto\SubmissionCreateRequest;
use Equed\EquedLms\Dto\SubmissionEvaluateRequest;
use Equed\EquedLms\Domain\Service\ClockInterface;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Equed\EquedLms\Event\Submission\SubmissionReviewedEvent;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use PHPUnit\Framework\TestCase;

class SubmissionServiceTest extends TestCase
{
    use ProphecyTrait;

    private SubmissionService $subject;
    private $repository;
    private $persistence;
    private $eventDispatcher;
    private $clock;

    protected function setUp(): void
    {
        $this->repository      = $this->prophesize(UserSubmissionRepositoryInterface::class);
        $this->persistence     = $this->prophesize(PersistenceManagerInterface::class);
        $this->eventDispatcher = $this->prophesize(EventDispatcherInterface::class);
        $this->clock           = $this->prophesize(ClockInterface::class);

        $this->subject = new SubmissionService(
            $this->repository->reveal(),
            $this->persistence->reveal(),
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

    public function testCreateSubmissionPersistsViaRepository(): void
    {
        $now = new \DateTimeImmutable('2024-01-01');
        $this->clock->now()->willReturn($now);
        $timestamp = $now->getTimestamp();

        $this->repository->createSubmission(1, 2, 'n', 'f', 't', $timestamp)->shouldBeCalled();
        $this->persistence->persistAll()->shouldBeCalled();

        $dto = new SubmissionCreateRequest(1, 2, 'n', 'f', 't');
        $this->subject->createSubmission($dto);
    }

    public function testEvaluateSubmissionUpdatesAndDispatches(): void
    {
        $now = new \DateTimeImmutable('2024-02-01');
        $this->clock->now()->willReturn($now);
        $timestamp = $now->getTimestamp();

        $submission = new \stdClass();
        $this->repository->updateSubmission(5, 'e', 'f', 'c', 9, $timestamp)->shouldBeCalled();
        $this->persistence->persistAll()->shouldBeCalled();
        $this->repository->findByUid(5)->willReturn($submission);
        $this->eventDispatcher->dispatch(new SubmissionReviewedEvent($submission))->shouldBeCalled();

        $dto = new SubmissionEvaluateRequest(5, 9, 'e', 'f', 'c');
        $this->subject->evaluateSubmission($dto);
    }
}
