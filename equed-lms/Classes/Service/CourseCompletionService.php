<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Service\ClockInterface;
use Equed\EquedLms\Domain\Model\UserCourseRecord;
use Equed\EquedLms\Domain\Repository\UserCourseRecordRepositoryInterface;
use Equed\EquedLms\Factory\UserCourseRecordFactoryInterface;
use Equed\EquedLms\Event\Course\CourseCompletedEvent;
use Equed\EquedLms\Domain\Service\CourseCompletionServiceInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;

/**
 * Service responsible for marking user course records as completed.
 */
final class CourseCompletionService implements CourseCompletionServiceInterface
{
    public function __construct(
        private readonly UserCourseRecordRepositoryInterface $recordRepository,
        private readonly UserCourseRecordFactoryInterface  $recordFactory,
        private readonly PersistenceManagerInterface       $persistenceManager,
        private readonly EventDispatcherInterface          $eventDispatcher,
        private readonly ClockInterface                    $clock
    ) {
    }

    /**
     * Marks a user's course record as completed if not already done.
     *
     * @param int $feUserId   Frontend user UID
     * @param int $courseUid  Course UID
     * @return bool           True if the record was newly marked completed, false otherwise
     */
    public function markCompletedIfNotYet(int $feUserId, int $courseUid): bool
    {
        $record = $this->recordRepository->findOneByUserAndCourse($feUserId, $courseUid);

        if ($record === null) {
            $record = $this->recordFactory->createForUserAndCourse($feUserId, $courseUid);
            $this->recordRepository->add($record);
        }

        if ($record->isCompleted()) {
            return false;
        }

        $record->setCompleted(true);
        $record->setCompletedAt($this->clock->now());

        $this->persistenceManager->persistAll();
        $this->eventDispatcher->dispatch(new CourseCompletedEvent($record));

        return true;
    }
}
