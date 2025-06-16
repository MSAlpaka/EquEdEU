<?php

declare(strict_types=1);

namespace Equed\EquedLms\EventListener;

use Equed\EquedLms\Event\Progress\LessonProgressUpdatedEvent;
use Equed\EquedLms\Event\Progress\UserCourseProgressUpdatedEvent;
use Equed\EquedLms\Service\LogService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use TYPO3\CMS\Core\SingletonInterface;

/**
 * Logs progress update events for audit purposes.
 */
final class ProgressUpdateListener implements EventSubscriberInterface, SingletonInterface
{
    public function __construct(private readonly LogService $logService)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LessonProgressUpdatedEvent::class => 'onLessonProgressUpdated',
            UserCourseProgressUpdatedEvent::class => 'onUserCourseProgressUpdated',
        ];
    }

    public function onLessonProgressUpdated(LessonProgressUpdatedEvent $event): void
    {
        $progress = $event->getLessonProgress();
        $this->logService->logInfo('Lesson progress updated', [
            'lesson'   => $progress->getLesson()->getUid(),
            'user'     => $progress->getUserCourseRecord()?->getUser()?->getUid(),
            'progress' => $progress->getProgress(),
        ]);
    }

    public function onUserCourseProgressUpdated(UserCourseProgressUpdatedEvent $event): void
    {
        $record = $event->getUserCourseRecord();
        $this->logService->logInfo('Course progress updated', [
            'record'   => $record->getUid(),
            'user'     => $record->getUser()->getUid(),
            'progress' => $record->getProgressPercent(),
        ]);
    }
}
// EOF
