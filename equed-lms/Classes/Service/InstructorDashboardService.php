<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Repository\CourseInstanceRepositoryInterface;
use Equed\EquedLms\Domain\Repository\UserCourseRecordRepositoryInterface;
use Equed\EquedLms\Domain\Model\FrontendUser;

/**
 * Provides instructor-specific dashboard statistics and metrics.
 */
final class InstructorDashboardService
{
    public function __construct(
        private readonly CourseInstanceRepositoryInterface $courseInstanceRepository,
        private readonly UserCourseRecordRepositoryInterface $userCourseRecordRepository
    ) {
    }

    /**
     * Get aggregated dashboard data for the given instructor.
     *
     * @param FrontendUser $instructor
     * @return array<string,mixed>
     */
    public function getDashboardDataForInstructor(FrontendUser $instructor): array
    {
        $instructorId = (int)$instructor->getUid();

        $instances = $this->courseInstanceRepository->findByInstructor($instructorId);
        $records   = $this->userCourseRecordRepository->findByInstructor($instructorId);

        $validatedRecords = array_filter(
            $records,
            fn ($r) => $r->getStatus() === \Equed\EquedLms\Enum\UserCourseStatus::Validated
        );

        $openTasks = array_filter(
            $records,
            fn ($r) => $r->getStatus() === \Equed\EquedLms\Enum\UserCourseStatus::InProgress
        );

        return [
            'courseInstanceCount' => count($instances),
            'participantCount'    => count($records),
            'validatedRecords'    => count($validatedRecords),
            'openTasks'           => count($openTasks),
        ];
    }
}
