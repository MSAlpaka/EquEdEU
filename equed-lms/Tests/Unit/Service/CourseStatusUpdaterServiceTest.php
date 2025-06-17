<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Service\CourseStatusUpdaterService;
use Equed\EquedLms\Domain\Service\CertificateServiceInterface;
use Equed\EquedLms\Domain\Service\NotificationServiceInterface;
use Equed\EquedLms\Domain\Repository\UserCourseRecordRepositoryInterface;
use Equed\EquedLms\Domain\Service\ClockInterface;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use Equed\EquedLms\Domain\Model\UserCourseRecord;
use Equed\EquedLms\Domain\Model\CertificateDispatch;
use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Domain\Model\CourseInstance;
use Equed\EquedLms\Enum\CourseStatus;
use PHPUnit\Framework\TestCase;
use DateTimeImmutable;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;

class CourseStatusUpdaterServiceTest extends TestCase
{
    use ProphecyTrait;

    private CourseStatusUpdaterService $subject;
    private $certificateService;
    private $notificationService;
    private $repository;
    private $persistence;
    private $clock;

    protected function setUp(): void
    {
        $this->certificateService = $this->prophesize(CertificateServiceInterface::class);
        $this->notificationService = $this->prophesize(NotificationServiceInterface::class);
        $this->repository  = $this->prophesize(UserCourseRecordRepositoryInterface::class);
        $this->persistence = $this->prophesize(PersistenceManagerInterface::class);
        $this->clock       = $this->prophesize(ClockInterface::class);

        $this->subject = new CourseStatusUpdaterService(
            $this->certificateService->reveal(),
            $this->notificationService->reveal(),
            $this->repository->reveal(),
            $this->persistence->reveal(),
            $this->clock->reveal()
        );
    }

    public function testFinalizeUpdatesRecordIssuesCertificateAndSendsNotifications(): void
    {
        $record = $this->prophesize(UserCourseRecord::class);
        $user = $this->prophesize(FrontendUser::class);
        $instance = $this->prophesize(CourseInstance::class);
        $certificate = $this->prophesize(CertificateDispatch::class);
        $now = new DateTimeImmutable('2024-01-01 00:00:00');

        $record->setStatus(CourseStatus::Validated->value)->shouldBeCalled();
        $this->clock->now()->willReturn($now);
        $record->setCompletionDate($now)->shouldBeCalled();
        $this->repository->update($record->reveal())->shouldBeCalled();
        $this->persistence->persistAll()->shouldBeCalled();

        $this->certificateService->issueCertificate($record->reveal())->willReturn($certificate->reveal())->shouldBeCalled();
        $certificate->getQrCodeUrl()->willReturn('qr');

        $record->getFeUser()->willReturn($user->reveal());
        $record->getCourseInstance()->willReturn($instance->reveal());
        $instance->getUid()->willReturn(5);

        $this->notificationService->sendCourseCompletedNotice($user->reveal(), 5)->shouldBeCalled();
        $this->notificationService->sendCertificateIssuedInfo($user->reveal(), 'qr')->shouldBeCalled();

        $this->subject->finalize($record->reveal());
    }
}
