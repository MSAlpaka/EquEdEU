<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Repository\CourseInstanceRepositoryInterface;
use Equed\EquedLms\Domain\Repository\UserCourseRecordRepositoryInterface;
use Equed\EquedLms\Domain\Repository\UserProfileRepositoryInterface;
use Equed\EquedLms\Domain\Service\InstructorDashboardServiceInterface;
use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Dto\InstructorDashboardData;

/**
 * Provides instructor-specific dashboard statistics and metrics.
 */
final class InstructorDashboardService implements InstructorDashboardServiceInterface
{
    public function __construct(
        private readonly CourseInstanceRepositoryInterface $courseInstanceRepository,
        private readonly UserCourseRecordRepositoryInterface $userCourseRecordRepository,
        private readonly UserProfileRepositoryInterface $userProfileRepository,
    ) {
    }

    /**
     * Get aggregated dashboard data for the given instructor.
     *
     * @param FrontendUser $instructor
     */
    public function getDashboardDataForInstructor(FrontendUser $instructor): InstructorDashboardData
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

        return new InstructorDashboardData(
            count($instances),
            count($records),
            count($validatedRecords),
            count($openTasks),
        );
    }

    public function isInstructor(int $userId): bool
    {
        return $this->userProfileRepository->findByUserId($userId)?->isInstructor() ?? false;
    }

    public function getInstructorInstances(int $instructorId): array
    {
        return $this->courseInstanceRepository->findByInstructor($instructorId);
    }

    public function getInstructorParticipants(int $instructorId): array
    {
        return $this->userCourseRecordRepository->findByInstructor($instructorId);
    }
}
