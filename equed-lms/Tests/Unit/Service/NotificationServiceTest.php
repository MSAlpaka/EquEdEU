<?php

declare(strict_types=1);

namespace TYPO3\CMS\Extbase\Domain\Model {
    if (!class_exists(FrontendUser::class)) {
        class FrontendUser {
            private string $email;
            public function __construct(string $email = '') { $this->email = $email; }
            public function getEmail(): string { return $this->email; }
        }
    }
}

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Service\NotificationService;
use Equed\EquedLms\Service\MailServiceInterface;
use Equed\EquedLms\Domain\Service\LanguageServiceInterface;
use Equed\EquedLms\Domain\Repository\NotificationRepositoryInterface;
use Equed\EquedLms\Domain\Repository\FrontendUserRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;

if (!interface_exists(PersistenceManagerInterface::class)) {
    interface PersistenceManagerInterface { public function persistAll(); }
}

final class NotificationServiceTest extends TestCase
{
    use ProphecyTrait;

    private NotificationService $subject;
    private $mail;
    private $language;

    protected function setUp(): void
    {
        $this->mail = $this->prophesize(MailServiceInterface::class);
        $this->language = $this->prophesize(LanguageServiceInterface::class);
        $repo = $this->prophesize(NotificationRepositoryInterface::class);
        $userRepo = $this->prophesize(FrontendUserRepositoryInterface::class);
        $pm = $this->prophesize(PersistenceManagerInterface::class);

        $this->subject = new NotificationService(
            $this->mail->reveal(),
            $this->language->reveal(),
            $repo->reveal(),
            $userRepo->reveal(),
            $pm->reveal(),
        );
    }

    public function testNotifyCertifierSendsTranslatedMail(): void
    {
        $this->language->translate('notification.certifier.subject', ['course' => 'Basics'])
            ->willReturn('subj');
        $this->language->translate('notification.certifier.body', ['course' => 'Basics'])
            ->willReturn('body');
        $this->mail->sendMail('cert@example.com', 'subj', 'body')->shouldBeCalled();

        $this->subject->notifyCertifier('cert@example.com', 'Basics');
    }

    public function testSendCourseCompletedNoticeSkipsWhenNoEmail(): void
    {
        $user = new FrontendUser('');
        $this->mail->sendMail(\Prophecy\Argument::cetera())->shouldNotBeCalled();
        $this->subject->sendCourseCompletedNotice($user, 1);
    }

    public function testNotifySendsMailWhenEmailPresent(): void
    {
        $user = new FrontendUser('john@example.com');
        $this->mail->sendMail('john@example.com', 'Hello', 'Body')->shouldBeCalled();

        $this->subject->notify($user, 'Hello', 'Body');
    }

    public function testSendCertificateIssuedInfoUsesTranslations(): void
    {
        $user = new FrontendUser('john@example.com');
        $this->language->translate('notification.certificate_issued.subject')
            ->willReturn('sub');
        $this->language->translate('notification.certificate_issued.body', ['url' => 'http://qrcode'])
            ->willReturn('bod');
        $this->mail->sendMail('john@example.com', 'sub', 'bod')->shouldBeCalled();

        $this->subject->sendCertificateIssuedInfo($user, 'http://qrcode');
    }
}
