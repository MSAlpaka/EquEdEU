<?php

declare(strict_types=1);

namespace Equed\EquedLms\EventListener;

use Equed\EquedLms\Event\Course\CourseValidatedEvent;
use Equed\EquedLms\Domain\Service\CertificateServiceInterface;
use Equed\EquedLms\Service\LogService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use TYPO3\CMS\Core\SingletonInterface;

/**
 * Listens for course validation events and triggers certificate creation.
 */
final class CourseValidationListener implements EventSubscriberInterface, SingletonInterface
{
    public function __construct(
        protected readonly CertificateServiceInterface $certificateService,
        protected readonly LogService $logService
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            CourseValidatedEvent::class => 'onCourseValidated',
        ];
    }

    /**
     * Handles the CourseValidatedEvent by issuing a certificate and logging the action.
     *
     * @param CourseValidatedEvent $event
     */
    public function onCourseValidated(CourseValidatedEvent $event): void
    {
        $userCourseRecord = $event->getUserCourseRecord();
        $this->certificateService->createCertificateForCourseCompletion($userCourseRecord);
        $this->logService->logInfo(
            'Course validated and certificate triggered',
            [
                'userId' => $userCourseRecord->getFeUser()?->getUid(),
                'courseInstanceId' => $userCourseRecord->getCourseInstance()?->getUid(),
            ]
        );
    }
}
// EOF

