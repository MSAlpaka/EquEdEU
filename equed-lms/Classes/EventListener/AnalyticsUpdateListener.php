<?php

declare(strict_types=1);

namespace Equed\EquedLms\EventListener;

use Equed\EquedLms\Event\Course\UserCourseRecordUpdatedEvent;
use Equed\EquedLms\Service\LogService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use TYPO3\CMS\Core\SingletonInterface;

/**
 * Example listener updating analytics when course records change.
 */
final class AnalyticsUpdateListener implements EventSubscriberInterface, SingletonInterface
{
    public function __construct(
        protected readonly LogService $logService
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UserCourseRecordUpdatedEvent::class => 'onRecordUpdated',
        ];
    }

    public function onRecordUpdated(UserCourseRecordUpdatedEvent $event): void
    {
        $record = $event->getUserCourseRecord();
        $this->logService->logInfo(
            'User course record updated',
            [
                'record'   => $record->getUid(),
                'property' => $event->getProperty(),
                'user'     => $record->getUser()?->getUid(),
            ]
        );
    }
}

