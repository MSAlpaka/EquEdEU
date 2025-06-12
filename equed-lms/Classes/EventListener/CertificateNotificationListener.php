<?php

declare(strict_types=1);

namespace Equed\EquedLms\EventListener;

use Equed\EquedLms\Domain\Repository\NotificationRepository;
use Equed\EquedLms\Event\CertificateIssuedEvent;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Annotations\EventListener;

/**
 * Sends a notification when a certificate is issued.
 *
 * @EventListener(
 *     identifier="certificate_notification_listener",
 *     after={"typo3.eventlistener"},
 *     eventName=Equed\EquedLms\Event\CertificateIssuedEvent::class
 * )
 */
final class CertificateNotificationListener
{
    private NotificationRepository $notificationRepository;
    private GptTranslationServiceInterface $translationService;
    private PersistenceManagerInterface $persistenceManager;
    private FlashMessageService $flashMessageService;

    public function __construct(
        NotificationRepository $notificationRepository,
        GptTranslationServiceInterface $translationService,
        PersistenceManagerInterface $persistenceManager,
        FlashMessageService $flashMessageService
    ) {
        $this->notificationRepository = $notificationRepository;
        $this->translationService    = $translationService;
        $this->persistenceManager    = $persistenceManager;
        $this->flashMessageService   = $flashMessageService;
    }

    /**
     * Handle certificate issued events.
     */
    public function __invoke(CertificateIssuedEvent $event): void
    {
        $user = $event->getUser();
        $messageKey = 'notification.certificate.issued';
        $message    = $this->translationService->translate(
            $messageKey,
            ['uid' => $user->getUid()]
        )
            ?? 'Your certificate has been issued.';

        $notification = $this->notificationRepository->create([
            'feUser' => $user,
            'message' => $message,
            'type' => 'certificate',
            'lang' => $user->getUserProfile()?->getLanguage() ?? 'en',
            'read' => false,
            'crdate' => new \DateTimeImmutable(),
            'tstamp' => new \DateTimeImmutable(),
        ]);

        $this->notificationRepository->add($notification);
        $this->persistenceManager->persistAll();

        $this->flashMessageService
            ->getMessageQueueByIdentifier()
            ->enqueue(
                $this->translationService->translate('flash.certificate_notification_sent')
                    ?? 'Notification sent to user.',
                \TYPO3\CMS\Core\Messaging\FlashMessage::OK
            );
    }
}
// EOF
