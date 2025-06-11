<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Domain\Model;

use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Domain\Model\CertificateDesign;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;

class CertificateDesignTest extends TestCase
{
    private CertificateDesign $subject;

    protected function setUp(): void
    {
        $this->subject = new CertificateDesign();
    }

    public function testSettersAndGetters(): void
    {
        $file = new FileReference();

        $this->subject->setName('Modern');
        $this->subject->setDescription('desc');
        $this->subject->setTemplateFile($file);
        $this->subject->setFontFamily('Sans');
        $this->subject->setBackgroundColor('#fff');
        $this->subject->setTextColor('#000');
        $this->subject->setActive(true);

        $this->assertSame('Modern', $this->subject->getName());
        $this->assertSame('desc', $this->subject->getDescription());
        $this->assertSame($file, $this->subject->getTemplateFile());
        $this->assertSame('Sans', $this->subject->getFontFamily());
        $this->assertSame('#fff', $this->subject->getBackgroundColor());
        $this->assertSame('#000', $this->subject->getTextColor());
        $this->assertTrue($this->subject->isActive());
    }
}
