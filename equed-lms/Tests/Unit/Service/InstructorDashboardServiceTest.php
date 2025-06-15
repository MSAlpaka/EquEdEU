<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Service\InstructorDashboardService;
use Equed\EquedLms\Domain\Repository\CourseInstanceRepositoryInterface;
use Equed\EquedLms\Domain\Repository\UserCourseRecordRepositoryInterface;
use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Domain\Model\UserCourseRecord;
use Equed\EquedLms\Domain\Model\CourseInstance;
use Equed\EquedLms\Enum\UserCourseStatus;
use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;

final class InstructorDashboardServiceTest extends TestCase
{
    use ProphecyTrait;

    public function testAggregatesRecordCounts(): void
    {
        $ciRepo = $this->prophesize(CourseInstanceRepositoryInterface::class);
        $ucRepo = $this->prophesize(UserCourseRecordRepositoryInterface::class);

        $instances = [new CourseInstance(), new CourseInstance()];
        $ciRepo->findByInstructor(5)->willReturn($instances);

        $r1 = new UserCourseRecord();
        $r1->setStatus(UserCourseStatus::Validated);
        $r2 = new UserCourseRecord();
        $r2->setStatus(UserCourseStatus::InProgress);
        $r3 = new UserCourseRecord();
        $r3->setStatus(UserCourseStatus::InProgress);

        $ucRepo->findByInstructor(5)->willReturn([$r1, $r2, $r3]);

        $service = new InstructorDashboardService($ciRepo->reveal(), $ucRepo->reveal());

        $instructor = new FrontendUser();
        $instructor->_setProperty('uid', 5);

        $result = $service->getDashboardDataForInstructor($instructor);

        $this->assertSame(2, $result['courseInstanceCount']);
        $this->assertSame(3, $result['participantCount']);
        $this->assertSame(1, $result['validatedRecords']);
        $this->assertSame(2, $result['openTasks']);
    }
}
