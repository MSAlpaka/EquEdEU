<?php

declare(strict_types=1);

namespace Equed\EquedLms\EventListener;

use Equed\EquedLms\Event\Qms\QmsCaseEscalatedEvent;
use Equed\EquedLms\Service\NotificationService;
use Equed\EquedLms\Service\LogService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use TYPO3\CMS\Core\SingletonInterface;

/**
 * Listens for QMS case escalation events and handles notifications/logging.
 */
final class QmsEscalationListener implements EventSubscriberInterface, SingletonInterface
{
    public function __construct(
        protected readonly NotificationService $notificationService,
        protected readonly LogService $logService
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            QmsCaseEscalatedEvent::class => 'onCaseEscalated',
        ];
    }

    /**
     * Handle the QmsCaseEscalatedEvent.
     *
     * @param QmsCaseEscalatedEvent $event
     */
    public function onCaseEscalated(QmsCaseEscalatedEvent $event): void
    {
        $case = $event->getCase();
        $instructorId = $case->getInstructor()?->getUid();
        $this->notificationService->notifyServiceCenter(
            'QMS case escalated',
            [
                'caseUid'     => $case->getUid(),
                'instructor'  => $instructorId,
                'courseInst'  => $case->getCourseInstance()?->getUid(),
            ]
        );
        $this->logService->logWarning(
            'QMS case escalated',
            [
                'caseUid'     => $case->getUid(),
                'instructor'  => $instructorId,
                'courseInst'  => $case->getCourseInstance()?->getUid(),
            ]
        );
    }
}
// EOF
