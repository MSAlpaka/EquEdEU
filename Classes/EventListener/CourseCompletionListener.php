<?php

declare(strict_types=1);

namespace Equed\EquedLms\Listener;

use Equed\EquedLms\Event\CourseCompletedEvent;
use Equed\EquedLms\Event\CertificateIssuedEvent;
use Equed\EquedLms\Service\AutoCertificationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Repository\UserCourseRecordRepository;
use Psr\EventDispatcher\EventDispatcherInterface;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use TYPO3\CMS\Core\Annotations\EventListener;

/**
 * Listens for course completion and triggers certification workflow.
 *
 * @EventListener(
 *     identifier="course_completion_listener",
 *     after={"typo3.eventlistener"},
 *     eventName=Equed\EquedLms\Event\CourseCompletedEvent::class
 * )
 */
final class CourseCompletionListener
{
    private AutoCertificationServiceInterface $certificationService;
    private UserCourseRecordRepository $userCourseRecordRepository;
    private PersistenceManagerInterface $persistenceManager;
    private EventDispatcherInterface $eventDispatcher;
    private GptTranslationServiceInterface $translationService;

    public function __construct(
        AutoCertificationServiceInterface $certificationService,
        UserCourseRecordRepository $userCourseRecordRepository,
        PersistenceManagerInterface $persistenceManager,
        EventDispatcherInterface $eventDispatcher,
        GptTranslationServiceInterface $translationService
    ) {
        $this->certificationService         = $certificationService;
        $this->userCourseRecordRepository   = $userCourseRecordRepository;
        $this->persistenceManager           = $persistenceManager;
        $this->eventDispatcher              = $eventDispatcher;
        $this->translationService           = $translationService;
    }

    /**
     * Handle course completion: validate, issue certificate, notify.
     */
    public function __invoke(CourseCompletedEvent $event): void
    {
        $userCourseRecord = $this->userCourseRecordRepository->findByIdentifier(
            $event->getUserCourseRecordUid()
        );
        if ($userCourseRecord === null) {
            return;
        }

        // Auto-validate if feature toggle enabled
        if ($this->certificationService->isAutoValidateEnabled()) {
            $this->certificationService->validate($userCourseRecord);
            $this->userCourseRecordRepository->update($userCourseRecord);
            $this->persistenceManager->persistAll();
            // dispatch validation event
            $this->eventDispatcher->dispatch(new CourseCompletionValidatedEvent($userCourseRecord->getUid()));
        }

        // Issue certificate
        $certificate = $this->certificationService->issueCertificate($userCourseRecord);
        $this->persistenceManager->persistAll();

        // dispatch certificate issued event
        $this->eventDispatcher->dispatch(new CertificateIssuedEvent(
            $userCourseRecord->getUser(),
            $certificate->getUid()
        ));
    }
}
// EOF
