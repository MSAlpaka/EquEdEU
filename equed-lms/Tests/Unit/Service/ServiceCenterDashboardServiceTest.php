<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model {
    if (!class_exists(Course::class)) {
        class Course { public function __construct(private string $title=''){ $this->title=$title; } public function getTitle(): string { return $this->title; } }
    }
    if (!class_exists(FrontendUser::class)) {
        class FrontendUser { public function __construct(private string $name=''){ $this->name=$name; } public function getName(): string { return $this->name; } }
    }
    if (!class_exists(Certificate::class)) {
        class Certificate {
            public function __construct(private ?Course $course=null, private ?FrontendUser $feUser=null, private ?\DateTimeImmutable $submittedAt=null) {}
            public function getCourse(): ?Course { return $this->course; }
            public function getFeUser(): ?FrontendUser { return $this->feUser; }
            public function getSubmittedAt(): ?\DateTimeImmutable { return $this->submittedAt; }
        }
    }
    if (!class_exists(UserSubmission::class)) {
        use Equed\EquedLms\Enum\SubmissionStatus;
        class UserSubmission {
            public function __construct(private string $type, private ?FrontendUser $user, private SubmissionStatus $status) {}
            public function getType(): string { return $this->type; }
            public function getFeUser(): ?FrontendUser { return $this->user; }
            public function getStatus(): SubmissionStatus { return $this->status; }
        }
    }
    if (!class_exists(QmsCase::class)) {
        class QmsCase {
            public function __construct(private string $title, private string $status, private ?\DateTimeImmutable $date) {}
            public function getTitle(): string { return $this->title; }
            public function getStatus(): string { return $this->status; }
            public function getDate(): ?\DateTimeImmutable { return $this->date; }
        }
    }
}

namespace Equed\EquedLms\Domain\Repository {
    if (!interface_exists(CertificateRepositoryInterface::class)) {
        interface CertificateRepositoryInterface { public function findPendingByServiceCenter(int $centerId): array; }
    }
    if (!interface_exists(UserSubmissionRepositoryInterface::class)) {
        interface UserSubmissionRepositoryInterface { public function findPendingByServiceCenter(int $centerId): array; }
    }
    if (!interface_exists(QmsCaseRepositoryInterface::class)) {
        interface QmsCaseRepositoryInterface { public function findOpenByServiceCenter(int $centerId): array; }
    }
}

namespace Equed\EquedLms\Tests\Unit\Service;

use DateTimeImmutable;
use Equed\EquedLms\Enum\SubmissionStatus;
use Equed\EquedLms\Service\ServiceCenterDashboardService;
use Equed\EquedLms\Domain\Repository\CertificateRepositoryInterface;
use Equed\EquedLms\Domain\Repository\UserSubmissionRepositoryInterface;
use Equed\EquedLms\Domain\Repository\QmsCaseRepositoryInterface;
use Equed\EquedLms\Domain\Service\LanguageServiceInterface;
use Equed\EquedLms\Domain\Model\Certificate;
use Equed\EquedLms\Domain\Model\Course;
use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Domain\Model\UserSubmission;
use Equed\EquedLms\Domain\Model\QmsCase;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;

final class ServiceCenterDashboardServiceTest extends TestCase
{
    use ProphecyTrait;

    private $certRepo;
    private $subRepo;
    private $qmsRepo;
    private $lang;
    private ServiceCenterDashboardService $subject;

    protected function setUp(): void
    {
        $this->certRepo = $this->prophesize(CertificateRepositoryInterface::class);
        $this->subRepo  = $this->prophesize(UserSubmissionRepositoryInterface::class);
        $this->qmsRepo  = $this->prophesize(QmsCaseRepositoryInterface::class);
        $this->lang     = $this->prophesize(LanguageServiceInterface::class);

        $this->subject = new ServiceCenterDashboardService(
            $this->certRepo->reveal(),
            $this->subRepo->reveal(),
            $this->qmsRepo->reveal(),
            $this->lang->reveal(),
        );
    }

    public function testMapsEntitiesToDashboardData(): void
    {
        $course = new Course('Basics');
        $user   = new FrontendUser('John');
        $cert   = new Certificate($course, $user, new DateTimeImmutable('2024-05-01'));
        $sub    = new UserSubmission('upload', $user, SubmissionStatus::Pending);
        $case   = new QmsCase('Case A', 'pending', new DateTimeImmutable('2024-04-02'));

        $this->certRepo->findPendingByServiceCenter(5)->willReturn([$cert]);
        $this->subRepo->findPendingByServiceCenter(5)->willReturn([$sub]);
        $this->qmsRepo->findOpenByServiceCenter(5)->willReturn([$case]);

        $this->lang->translate('status.pending', Argument::cetera())->willReturn('pending')->shouldBeCalledTimes(2);

        $data = $this->subject->getDashboardDataForServiceCenter(5);

        $this->assertSame(5, $data->getCenterId());
        $this->assertSame('Basics', $data->getCertificates()[0]['course']);
        $this->assertSame('John', $data->getCertificates()[0]['user']);
        $this->assertSame('2024-05-01', $data->getCertificates()[0]['submittedAt']);
        $this->assertSame('pending', $data->getSubmissions()[0]['status']);
        $this->assertSame('pending', $data->getQmsCases()[0]['status']);
    }

    public function testUsesUnknownKeyForUnsupportedStatus(): void
    {
        $user = new FrontendUser('Jane');
        $sub  = new UserSubmission('quiz', $user, SubmissionStatus::Approved);
        $case = new QmsCase('Case', 'closed', null);

        $this->certRepo->findPendingByServiceCenter(2)->willReturn([]);
        $this->subRepo->findPendingByServiceCenter(2)->willReturn([$sub]);
        $this->qmsRepo->findOpenByServiceCenter(2)->willReturn([$case]);

        $this->lang->translate('status.unknown', Argument::cetera())->willReturn('unknown')->shouldBeCalledTimes(2);

        $data = $this->subject->getDashboardDataForServiceCenter(2);

        $this->assertSame('unknown', $data->getSubmissions()[0]['status']);
        $this->assertSame('unknown', $data->getQmsCases()[0]['status']);
    }
}
