<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Repository\UserCourseRecordRepositoryInterface;
use Equed\EquedLms\Domain\Repository\CertificateRepositoryInterface;

/**
 * Service for retrieving statistical data.
 */
final class StatisticsService
{
    public function __construct(
        private readonly UserCourseRecordRepositoryInterface $userCourseRecordRepository,
        private readonly CertificateRepositoryInterface $certificateRepository
    ) {
    }

    /**
     * Count certificates assigned to a specific instructor.
     *
     * @param int $instructorFeUser FE user ID of the instructor
     * @return int Number of certificates
     */
    public function countCertificatesByInstructor(int $instructorFeUser): int
    {
        return $this->certificateRepository->countByInstructor($instructorFeUser);
    }

    /**
     * Count all completed courses across all users.
     *
     * @return int Number of completed course records
     */
    public function countCompletedCourses(): int
    {
        return $this->userCourseRecordRepository->countByStatus('completed');
    }

    /**
     * Get course statistics for a specific user.
     *
     * @param int $feUser FE user ID
     * @return array{completed: int, active: int, total: int}
     */
    public function getUserCourseStatistics(int $feUser): array
    {
        $totalCount     = $this->userCourseRecordRepository->countByUserId($feUser);
        $completedCount = $this->userCourseRecordRepository->countByUserIdAndStatus($feUser, 'completed');
        $activeCount    = $this->userCourseRecordRepository->countByUserIdAndStatus($feUser, 'active');

        return [
            'completed' => $completedCount,
            'active'    => $activeCount,
            'total'     => $totalCount,
        ];
    }
}
