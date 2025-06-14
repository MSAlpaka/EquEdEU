<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Domain\Model\CertificateDispatch;
use Equed\EquedLms\Domain\Model\UserCourseRecord;
use Equed\EquedLms\Domain\Repository\CertificateDispatchRepository;
use Equed\EquedLms\Factory\CertificateDispatchFactoryInterface;
use Equed\EquedLms\Service\CertificateService;
use Equed\EquedLms\Domain\Service\CertificateServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\ClockInterface;
use Equed\EquedLms\Domain\Service\NotificationServiceInterface;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use PHPUnit\Framework\TestCase;

class CertificateServiceTest extends TestCase
{
    use ProphecyTrait;

    private CertificateServiceInterface $subject;
    private $repository;
    private $factory;
    private $translator;
    private $notifier;
    private $clock;

    protected function setUp(): void
    {
        $this->repository = $this->prophesize(CertificateDispatchRepository::class);
        $this->factory = $this->prophesize(CertificateDispatchFactoryInterface::class);
        $this->translator = $this->prophesize(GptTranslationServiceInterface::class);
        $this->notifier = $this->prophesize(NotificationServiceInterface::class);
        $this->clock = $this->prophesize(ClockInterface::class);

        $this->subject = new CertificateService(
            $this->repository->reveal(),
            $this->factory->reveal(),
            $this->translator->reveal(),
            $this->notifier->reveal(),
            $this->clock->reveal(),
            'https://example.com'
        );
    }

    public function testIssuesNewCertificate(): void
    {
        $record = $this->prophesize(UserCourseRecord::class);
        $dispatch = $this->prophesize(CertificateDispatch::class);

        $this->repository->findByUserCourseRecord($record)->willReturn(null);
        $this->factory->createFromUserCourseRecord($record, 'pdf', \Prophecy\Argument::type('string'))
            ->willReturn($dispatch);
        $this->repository->add($dispatch)->shouldBeCalled();

        $result = $this->subject->issueCertificate($record->reveal());
        $this->assertSame($dispatch->reveal(), $result);
    }

    public function testReturnsExistingDispatch(): void
    {
        $record = $this->prophesize(UserCourseRecord::class);
        $existing = $this->prophesize(CertificateDispatch::class);
        $this->repository->findByUserCourseRecord($record)->willReturn($existing);

        $result = $this->subject->issueCertificate($record->reveal());
        $this->assertSame($existing->reveal(), $result);
    }

    public function testSendCertificateNotificationTranslatesAndNotifies(): void
    {
        $dispatch = $this->prophesize(CertificateDispatch::class);
        $course = $this->prophesize(\Equed\EquedLms\Domain\Model\CourseInstance::class);
        $user = $this->prophesize(\Equed\EquedLms\Domain\Model\FrontendUser::class);

        $course->getTitle()->willReturn('Course');
        $user->getName()->willReturn('John');

        $dispatch->getCourseInstance()->willReturn($course->reveal());
        $dispatch->getFeUser()->willReturn($user->reveal());
        $dispatch->getQrCodeUrl()->willReturn('url');

        $this->translator->translate('certificate.notification.subject', ['course' => 'Course'])
            ->willReturn('sub');
        $this->translator->translate('certificate.notification.body', ['name' => 'John', 'qrCodeUrl' => 'url'])
            ->willReturn('body');

        $this->notifier->notify($user->reveal(), 'sub', 'body')->shouldBeCalled();

        $this->subject->sendCertificateNotification($dispatch->reveal());
    }
}
