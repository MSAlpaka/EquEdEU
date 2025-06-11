<?php

declare(strict_types=1);

namespace TYPO3\CMS\Extbase\Domain\Model {
    if (!class_exists(FrontendUser::class)) {
        class FrontendUser
        {
            private int $uid;
            private ?object $userProfile;
            public function __construct(int $uid = 0, ?object $userProfile = null)
            {
                $this->uid = $uid;
                $this->userProfile = $userProfile;
            }
            public function getUid(): int
            {
                return $this->uid;
            }
            public function getUserProfile(): ?object
            {
                return $this->userProfile;
            }
        }
    }
}

namespace Equed\EquedLms\Event {
    use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;

    if (!class_exists(CertificateIssuedEvent::class)) {
        final class CertificateIssuedEvent
        {
            public function __construct(private FrontendUser $user, private int $certificateUid)
            {
            }
            public function getUser(): FrontendUser
            {
                return $this->user;
            }
            public function getCertificateUid(): int
            {
                return $this->certificateUid;
            }
        }
    }
}

namespace Equed\EquedLms\Tests\Unit\EventListener {

    use PHPUnit\Framework\TestCase;
    use Prophecy\PhpUnit\ProphecyTrait;
    use Equed\EquedLms\Listener\CertificateNotificationListener;
    use Equed\EquedLms\Domain\Repository\NotificationRepository;
    use Equed\EquedLms\Service\GptTranslationServiceInterface;
    use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
    use TYPO3\CMS\Core\Messaging\FlashMessageService;
    use Equed\EquedLms\Event\CertificateIssuedEvent;
    use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;
    use Prophecy\Argument;

    final class CertificateNotificationListenerTest extends TestCase
    {
        use ProphecyTrait;

        private CertificateNotificationListener $subject;
        private $notificationRepository;
        private $translationService;
        private $persistenceManager;
        private $flashMessageService;

        protected function setUp(): void
        {
            $this->notificationRepository = $this->prophesize(NotificationRepository::class);
            $this->translationService = $this->prophesize(GptTranslationServiceInterface::class);
            $this->persistenceManager = $this->prophesize(PersistenceManagerInterface::class);
            $this->flashMessageService = $this->prophesize(FlashMessageService::class);

            $this->notificationRepository->create(Argument::type('array'))->willReturn([]);
            $this->notificationRepository->add(Argument::any())->shouldBeCalled();
            $this->persistenceManager->persistAll()->shouldBeCalled();
            $queue = $this->prophesize();
            $this->flashMessageService->getMessageQueueByIdentifier()->willReturn($queue->reveal());
            $queue->enqueue(Argument::cetera())->shouldBeCalled();

            $this->subject = new CertificateNotificationListener(
                $this->notificationRepository->reveal(),
                $this->translationService->reveal(),
                $this->persistenceManager->reveal(),
                $this->flashMessageService->reveal()
            );
        }

        public function testInvokeDoesNotThrowTypeError(): void
        {
            $profile = new class () {
                public function getLanguage(): string
                {
                    return 'en';
                }
            };
            $user = new FrontendUser(123, $profile);

            $this->translationService
                ->translate('notification.certificate.issued', ['uid' => 123])
                ->willReturn('text');
            $this->translationService
                ->translate('flash.certificate_notification_sent')
                ->willReturn('sent');

            $event = new CertificateIssuedEvent($user, 99);

            $this->subject->__invoke($event);

            $this->addToAssertionCount(1);
        }
    }
}
