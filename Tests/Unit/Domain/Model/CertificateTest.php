<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Domain\Model;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Domain\Model\Certificate;
use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Domain\Model\CourseProgram;
use Equed\EquedLms\Domain\Model\CertificateDispatch;
use Equed\EquedLms\Domain\Model\CourseCertificate;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;

class CertificateTest extends TestCase
{
    private Certificate $subject;

    protected function setUp(): void
    {
        $this->subject = new Certificate();
    }

    public function testSettersAndGetters(): void
    {
        $user = new FrontendUser();
        $program = new CourseProgram();
        $dispatch = new CertificateDispatch();
        $courseCert = new CourseCertificate();
        $file = new FileReference();
        $issued = new DateTimeImmutable('2025-01-01');

        $this->subject->setFeUser($user);
        $this->subject->setCourseProgram($program);
        $this->subject->setCertificateDispatch($dispatch);
        $this->subject->setCourseCertificate($courseCert);
        $this->subject->setFile($file);
        $this->subject->setIssuedAt($issued);
        $this->subject->setCertificateNumber('A123');

        $this->assertSame($user, $this->subject->getFeUser());
        $this->assertSame($program, $this->subject->getCourseProgram());
        $this->assertSame($dispatch, $this->subject->getCertificateDispatch());
        $this->assertSame($courseCert, $this->subject->getCourseCertificate());
        $this->assertSame($file, $this->subject->getFile());
        $this->assertSame($issued, $this->subject->getIssuedAt());
        $this->assertSame('A123', $this->subject->getCertificateNumber());
    }
}
