<?php

declare(strict_types=1);

namespace Equed\EquedLms\EventListener;

use Equed\EquedLms\Domain\Repository\CertificateDispatchRepositoryInterface;
use Equed\EquedLms\Domain\Repository\UserCourseRecordRepositoryInterface;
use Equed\EquedLms\Service\CertificateGeneratorInterface;
use Equed\EquedLms\Enum\UserCourseStatus;
use Equed\EquedLms\Event\Course\CourseCompletionValidatedEvent;
use Psr\EventDispatcher\ListenerProviderInterface;
use TYPO3\CMS\Core\Annotations\EventListener;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;

/**
 * Automatically issues certificates when a course completion is validated.
 *
 * @EventListener(
 *     identifier="auto_certification_listener",
 *     after={"typo3.eventlistener"},
 *     eventName=Equed\EquedLms\Event\Course\CourseCompletionValidatedEvent::class
 * )
 */
final class AutoCertificationListener
{
    private CertificateDispatchRepositoryInterface $dispatchRepository;
    private UserCourseRecordRepositoryInterface $recordRepository;
    private CertificateGeneratorInterface $generator;
    private PersistenceManagerInterface $persistenceManager;
    private FlashMessageService $flashMessageService;

    public function __construct(
        CertificateDispatchRepositoryInterface $dispatchRepository,
        UserCourseRecordRepositoryInterface $recordRepository,
        CertificateGeneratorInterface $generator,
        PersistenceManagerInterface $persistenceManager,
        FlashMessageService $flashMessageService
    ) {
        $this->dispatchRepository    = $dispatchRepository;
        $this->recordRepository      = $recordRepository;
        $this->generator             = $generator;
        $this->persistenceManager    = $persistenceManager;
        $this->flashMessageService   = $flashMessageService;
    }

    /**
     * Handle course completion validated events.
     */
    public function __invoke(CourseCompletionValidatedEvent $event): void
    {
        $userCourseRecord = $this->recordRepository->findByIdentifier($event->getRecordUid());
        if ($userCourseRecord === null) {
            return;
        }

        if ($userCourseRecord->getStatus() !== UserCourseStatus::Validated) {
            return;
        }

        $existing = $this->dispatchRepository->findByUserCourseRecord($userCourseRecord);
        if ($existing !== []) {
            return;
        }

        try {
            $certificate = $this->generator->generateFor($userCourseRecord);
            $this->dispatchRepository->add($certificate);
            $this->persistenceManager->persistAll();
            $this->flashMessageService->getMessageQueueByIdentifier()->enqueueFromValidatedEvent(
                'Certificate issued automatically.',
                \TYPO3\CMS\Core\Messaging\FlashMessage::OK
            );
        } catch (\Throwable $e) {
            $this->flashMessageService->getMessageQueueByIdentifier()->enqueueFromValidatedEvent(
                'Certificate issuance failed: ' . $e->getMessage(),
                \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR
            );
        }
    }
}
// EOF
