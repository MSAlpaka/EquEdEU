<?php declare(strict_types=1);

namespace Equed\EquedCore\Tests\Unit\Domain\Model;

use PHPUnit\Framework\TestCase;
use Equed\EquedCore\Domain\Model\DocumentUpload;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;

class DocumentUploadTest extends TestCase
{
    public function testSetGetFileReference(): void
    {
        $upload = new DocumentUpload();
        $fileRef = new FileReference();
        $upload->setFileReference($fileRef);
        $this->assertSame($fileRef, $upload->getFileReference());
    }

    public function testDefaultHiddenValue(): void
    {
        $upload = new DocumentUpload();
        $this->assertFalse($upload->isHidden());
    }

    public function testSetGetIsCertified(): void
    {
        $upload = new DocumentUpload();
        $upload->setIsCertified(true);
        $this->assertTrue($upload->isCertified());
    }
}
