<?php declare(strict_types=1);

namespace Equed\EquedCore\Tests\Unit\Domain\Model;

use PHPUnit\Framework\TestCase;
use Equed\EquedCore\Domain\Model\ExternalCertificate;
use Equed\EquedCore\Domain\Model\DocumentUpload;

class ExternalCertificateTest extends TestCase
{
    public function testSetGetCertificateNumber(): void
    {
        $cert = new ExternalCertificate();
        $cert->setCertificateNumber('123');
        $this->assertSame('123', $cert->getCertificateNumber());
    }

    public function testDefaultHiddenValue(): void
    {
        $cert = new ExternalCertificate();
        $this->assertFalse($cert->isHidden());
    }

    public function testSetGetRelatedDocument(): void
    {
        $cert = new ExternalCertificate();
        $doc = new DocumentUpload();
        $cert->setRelatedDocument($doc);
        $this->assertSame($doc, $cert->getRelatedDocument());
    }

    public function testSetGetIsValid(): void
    {
        $cert = new ExternalCertificate();
        $cert->setIsValid(true);
        $this->assertTrue($cert->isValid());
    }
}
