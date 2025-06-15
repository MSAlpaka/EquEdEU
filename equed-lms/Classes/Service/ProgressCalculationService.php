<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Repository\CourseInstanceRepositoryInterface;
use Equed\EquedLms\Domain\Repository\UserCourseRecordRepositoryInterface;
use Psr\Cache\CacheItemPoolInterface;
use Equed\EquedLms\Domain\Service\LanguageServiceInterface;
use Equed\EquedLms\Enum\ProgressStatus;
use Equed\EquedLms\Helper\ProgressCacheKeyHelper;

/**
 * Service for calculating user progress in courses.
 */
final class ProgressCalculationService
{

    public function __construct(
        private readonly CourseInstanceRepositoryInterface $courseInstanceRepository,
        private readonly UserCourseRecordRepositoryInterface $userCourseRecordRepository,
        private readonly CacheItemPoolInterface $cachePool,
        private readonly LanguageServiceInterface $languageService
    ) {
    }

    /**
     * Calculate the overall progress for a course program.
     *
     * @param int $userId          Frontend user id
     * @param int $courseProgramId Course program uid
     * @return float Progress percentage between 0 and 100
     */
    public function calculateCourseProgramProgress(int $userId, int $courseProgramId): float
    {
        $instances = $this->courseInstanceRepository->findByCourseProgram($courseProgramId);
        if ($instances === []) {
            return 0.0;
        }

        $total = count($instances);
        $sum = 0.0;

        foreach ($instances as $instance) {
            $sum += $this->calculateCourseInstanceProgress($userId, (int)$instance->getUid());
        }

        return $sum / $total;
    }

    /**
     * Calculate progress for a single course instance.
     *
     * @param int $userId          User identifier
     * @param int $courseInstanceId Course instance uid
     * @return float Progress percentage
     */
    public function calculateCourseInstanceProgress(int $userId, int $courseInstanceId): float
    {
        $cacheKey = ProgressCacheKeyHelper::courseInstance($userId, $courseInstanceId);
        $cacheItem = $this->cachePool->getItem($cacheKey);

        if ($cacheItem->isHit()) {
            return (float)$cacheItem->get();
        }

        $records = $this->userCourseRecordRepository->findByUserAndCourseInstance($userId, $courseInstanceId);
        if ($records === []) {
            $progress = 0.0;
        } else {
            $completed = 0;
            foreach ($records as $record) {
                if ($record->getStatus() === \Equed\EquedLms\Enum\UserCourseStatus::Passed) {
                    $completed++;
                }
            }
            $progress = ($completed / count($records)) * 100.0;
        }

        $cacheItem->set($progress);
        $this->cachePool->save($cacheItem);

        return $progress;
    }

    /**
     * Translate a human readable label for a progress value.
     *
     * @param float $progress Progress percent
     * @return string Localized label
     */
    public function getProgressLabel(float $progress): string
    {
        $status = match (true) {
            $progress >= 100.0 => ProgressStatus::Completed,
            $progress > 0.0    => ProgressStatus::InProgress,
            default            => ProgressStatus::NotStarted,
        };

        $key = sprintf('progress.%s', $status->value);

        return $this->languageService->translate($key, ['progress' => (int)round($progress)]);
    }

}
