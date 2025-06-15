<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\CourseInstance;
use Equed\EquedLms\Domain\Repository\CourseInstanceRepositoryInterface;
use Equed\EquedLms\Domain\Repository\UserCourseRecordRepositoryInterface;
use Equed\EquedLms\Domain\Service\CourseBookingServiceInterface;
use Equed\EquedLms\Factory\UserCourseRecordFactoryInterface;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;

final class CourseBookingService implements CourseBookingServiceInterface
{
    public function __construct(
        private readonly CourseInstanceRepositoryInterface $courseInstanceRepository,
        private readonly UserCourseRecordRepositoryInterface $recordRepository,
        private readonly UserCourseRecordFactoryInterface $recordFactory,
        private readonly PersistenceManagerInterface $persistenceManager,
    ) {
    }

    public function isAlreadyBooked(int $userId, int $courseInstanceId): bool
    {
        return $this->recordRepository->findOneByUserAndCourseInstance($userId, $courseInstanceId) !== null;
    }

    public function bookCourse(int $userId, int $courseInstanceId): void
    {
        if ($this->isAlreadyBooked($userId, $courseInstanceId)) {
            return;
        }

        $instance = $this->courseInstanceRepository->findByUid($courseInstanceId);
        if (! $instance instanceof CourseInstance) {
            throw new \InvalidArgumentException(sprintf('Course instance %d not found', $courseInstanceId));
        }

        $record = $this->recordFactory->createForUserAndInstance($userId, $instance);
        $this->recordRepository->add($record);
        $this->persistenceManager->persistAll();
    }
}

