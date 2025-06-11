<?php

declare(strict_types=1);

namespace Equed\EquedLms\EventListener;

use Equed\EquedLms\Event\Submission\SubmissionUploadedEvent;
use Equed\EquedLms\Service\NotificationService;
use Equed\EquedLms\Service\LogService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use TYPO3\CMS\Core\SingletonInterface;

/**
 * Listens for submission uploads to notify instructors and log the action.
 */
final class SubmissionNotificationListener implements EventSubscriberInterface, SingletonInterface
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
            SubmissionUploadedEvent::class => 'onSubmissionUploaded',
        ];
    }

    /**
     * Handle the event when a user uploads a submission.
     *
     * @param SubmissionUploadedEvent $event
     */
    public function onSubmissionUploaded(SubmissionUploadedEvent $event): void
    {
        $submission = $event->getSubmission();
        $ucr = $submission->getUserCourseRecord();
        $courseInstance = $ucr->getCourseInstance();

        // Collect instructor UIDs for this course instance
        $instructors = $courseInstance?->getInstructors()?->toArray() ?? [];
        $instructorIds = array_map(
            fn ($instructor) => $instructor->getUid(),
            $instructors
        );

        // Notify all instructors about the new submission
        $this->notificationService->notifyUsers(
            'submission.uploaded.notification',
            $instructorIds,
            [
                'submissionUid'   => $submission->getUid(),
                'courseInstance'  => $courseInstance?->getUid(),
                'studentUser'     => $ucr->getFeUser()?->getUid(),
            ],
        );

        // Log the notification
        $this->logService->logInfo(
            'Notified instructors of new submission',
            [
                'submission'      => $submission->getUid(),
                'instructors'     => $instructorIds,
            ],
        );
    }
}
// EOF
