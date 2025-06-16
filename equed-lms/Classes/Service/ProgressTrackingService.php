<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\CourseInstance;
use Equed\EquedLms\Domain\Model\UserCourseRecord;
use Equed\EquedLms\Factory\UserCourseRecordFactoryInterface;
use Equed\EquedLms\Domain\Repository\CourseInstanceRepositoryInterface;
use Equed\EquedLms\Domain\Repository\UserCourseRecordRepositoryInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Equed\EquedLms\Event\Progress\UserCourseProgressUpdatedEvent;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use Equed\EquedLms\Domain\Service\LanguageServiceInterface;
use Equed\EquedLms\Enum\ProgressStatus;
use Equed\EquedLms\Helper\ProgressCacheKeyHelper;

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
        private readonly LanguageServiceInterface $languageService,
        private readonly UserCourseRecordFactoryInterface $recordFactory,
        private readonly EventDispatcherInterface $eventDispatcher,
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
        $status = $this->determineStatus($progressPercent);
        $record->setStatus($status->value);

        $this->recordRepository->update($record);
        $this->persistenceManager->persistAll();
        $this->clearCache($userId, $courseInstanceId);
        $this->eventDispatcher->dispatch(new UserCourseProgressUpdatedEvent($record));

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
        $record = $this->recordFactory->createForUserAndInstance($userId, $instance);
        $this->recordRepository->add($record);

        return $record;
    }

    /**
     * Determine status code based on progress percentage.
     *
     * @param float $progressPercent
     * @return ProgressStatus
     */
    private function determineStatus(float $progressPercent): \Equed\EquedLms\Enum\ProgressStatus
    {
        return match (true) {
            $progressPercent >= 100.0 => ProgressStatus::Completed,
            $progressPercent > 0.0   => ProgressStatus::InProgress,
            default                  => ProgressStatus::NotStarted,
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
        $cacheKey = ProgressCacheKeyHelper::courseInstance($userId, $courseInstanceId);
        $this->cachePool->deleteItem($cacheKey);
    }

    /**
     * Get localized label for a status code.
     *
     * @param ProgressStatus $statusCode
     * @return string
     */
    public function getStatusLabel(ProgressStatus $statusCode): string
    {
        $key = sprintf('status.%s', $statusCode->value);

        return $this->languageService->translate($key);
    }
}
