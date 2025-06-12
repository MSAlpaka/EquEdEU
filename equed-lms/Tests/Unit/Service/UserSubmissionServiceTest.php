<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Domain\Repository\UserSubmissionRepositoryInterface;
use Equed\EquedLms\Service\UserSubmissionService;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use PHPUnit\Framework\TestCase;

class UserSubmissionServiceTest extends TestCase
{
    use ProphecyTrait;

    private UserSubmissionService $subject;
    private $repository;

    protected function setUp(): void
    {
        $this->repository = $this->prophesize(UserSubmissionRepositoryInterface::class);
        $this->subject = new UserSubmissionService($this->repository->reveal());
    }

    public function testGetSubmissionsForCourseInstanceDelegates(): void
    {
        $expected = [1];
        $this->repository->findByCourseInstance(42)->willReturn($expected);

        $this->assertSame($expected, $this->subject->getSubmissionsForCourseInstance(42));
    }

    public function testGetInstructorFeedbackStatusReturnsValue(): void
    {
        $submission = $this->prophesize(\stdClass::class);
        $submission->getStatus()->willReturn(\Equed\EquedLms\Enum\SubmissionStatus::Pending);
        $this->repository->findByUid(7)->willReturn($submission->reveal());

        $this->assertSame('pending', $this->subject->getInstructorFeedbackStatus(7));
    }

    public function testIsValidatableChecksStatus(): void
    {
        $submission = $this->prophesize(\stdClass::class);
        $submission->getStatus()->willReturn(\Equed\EquedLms\Enum\SubmissionStatus::Pending);
        $this->repository->findByUid(11)->willReturn($submission->reveal());

        $this->assertTrue($this->subject->isValidatable(11));
    }
}
