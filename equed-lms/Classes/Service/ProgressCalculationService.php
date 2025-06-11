<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Repository\CourseInstanceRepositoryInterface;
use Equed\EquedLms\Domain\Repository\UserCourseRecordRepositoryInterface;
use Psr\Cache\CacheItemPoolInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Service for calculating user progress in courses.
 */
final class ProgressCalculationService
{
    private const EXTENSION_KEY = 'equed_lms';

    public function __construct(
        private readonly CourseInstanceRepositoryInterface $courseInstanceRepository,
        private readonly UserCourseRecordRepositoryInterface $userCourseRecordRepository,
        private readonly CacheItemPoolInterface $cachePool,
        private readonly GptTranslationServiceInterface $translationService
    ) {
    }

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

    public function calculateCourseInstanceProgress(int $userId, int $courseInstanceId): float
    {
        $cacheKey = sprintf('progress_%d_%d', $userId, $courseInstanceId);
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

    public function getProgressLabel(float $progress): string
    {
        $key = match (true) {
            $progress >= 100.0 => 'progress.completed',
            $progress > 0.0 => 'progress.inProgress',
            default => 'progress.notStarted',
        };

        return $this->translate($key, ['progress' => (int)round($progress)]);
    }

    private function translate(string $key, array $arguments = []): string
    {
        if ($this->translationService->isEnabled()) {
            $translated = $this->translationService->translate($key, $arguments, self::EXTENSION_KEY);
            if ($translated !== null && $translated !== $key) {
                return $translated;
            }
        }

        return LocalizationUtility::translate($key, self::EXTENSION_KEY, $arguments) ?? $key;
    }
}
