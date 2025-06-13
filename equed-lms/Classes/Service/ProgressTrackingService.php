<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\CourseInstance;
use Equed\EquedLms\Domain\Model\UserCourseRecord;
use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Domain\Repository\CourseInstanceRepositoryInterface;
use Equed\EquedLms\Domain\Repository\UserCourseRecordRepositoryInterface;
use Psr\Cache\CacheItemPoolInterface;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use Equed\EquedLms\Domain\Service\LanguageServiceInterface;

/**
 * Service for tracking and persisting user course progress.
 */
final class ProgressTrackingService
{
    public function __construct(
        private readonly UserCourseRecordRepositoryInterface $recordRepository,
        private readonly CourseInstanceRepositoryInterface $courseInstanceRepository,
        private readonly PersistenceManagerInterface $persistenceManager,
        private readonly CacheItemPoolInterface $cachePool,
        private readonly LanguageServiceInterface $languageService
    ) {
    }

    /**
     * Track and persist user progress for a course instance.
     *
     * @param int   $userId             FE user ID
     * @param int   $courseInstanceId   Course instance ID
     * @param float $progressPercent    Progress percentage (0.0–100.0)
     *
     * @return UserCourseRecord
     */
    public function trackProgress(int $userId, int $courseInstanceId, float $progressPercent): UserCourseRecord
    {
        $instance = $this->courseInstanceRepository->findByUid($courseInstanceId);
        if ($instance === null) {
            throw new \InvalidArgumentException(sprintf('CourseInstance with ID %d not found', $courseInstanceId));
        }

        $record = $this->recordRepository
            ->findOneByUserAndCourseInstance($userId, $courseInstanceId)
            ?? $this->createUserCourseRecord($userId, $instance);

        $record->setProgressPercent($progressPercent);
        $record->setStatus($this->determineStatus($progressPercent));

        $this->recordRepository->update($record);
        $this->persistenceManager->persistAll();
        $this->clearCache($userId, $courseInstanceId);

        return $record;
    }

    /**
     * Create a new UserCourseRecord for a user and course instance.
     *
     * @param int            $userId    FE user ID
     * @param CourseInstance $instance  Course instance
     *
     * @return UserCourseRecord
     */
    private function createUserCourseRecord(int $userId, CourseInstance $instance): UserCourseRecord
    {
        $record = new UserCourseRecord();
        $user = new \Equed\EquedLms\Domain\Model\FrontendUser();
        $user->_setProperty('uid', $userId);
        $record->setUser($user);
        $record->setCourseInstance($instance);

        $this->recordRepository->add($record);

        return $record;
    }

    /**
     * Determine status code based on progress percentage.
     *
     * @param float $progressPercent
     * @return string
     */
    private function determineStatus(float $progressPercent): string
    {
        return match (true) {
            $progressPercent >= 100.0 => 'completed',
            $progressPercent > 0.0   => 'inProgress',
            default                  => 'notStarted',
        };
    }

    /**
     * Clear cache for the given user and course instance progress.
     *
     * @param int $userId
     * @param int $courseInstanceId
     */
    private function clearCache(int $userId, int $courseInstanceId): void
    {
        $cacheKey = sprintf('progress_%d_%d', $userId, $courseInstanceId);
        $this->cachePool->deleteItem($cacheKey);
    }

    /**
     * Get localized label for a status code.
     *
     * @param string $statusCode
     * @return string
     */
    public function getStatusLabel(string $statusCode): string
    {
        $key = sprintf('status.%s', $statusCode);

        return $this->languageService->translate($key);
    }
}
