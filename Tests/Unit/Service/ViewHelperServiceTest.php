<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use Equed\EquedLms\Service\ViewHelperService;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use Psr\Log\LoggerInterface;

class ViewHelperServiceTest extends TestCase
{
    use ProphecyTrait;

    private ViewHelperService $subject;
    private $objectManager;
    private $logger;

    protected function setUp(): void
    {
        $this->objectManager = $this->prophesize(ObjectManagerInterface::class);
        $this->logger = $this->prophesize(LoggerInterface::class);

        $this->subject = new ViewHelperService(
            $this->objectManager->reveal(),
            $this->logger->reveal()
        );
    }

    public function testFormatBooleanTrue(): void
    {
        $result = $this->subject->formatBoolean(true);
        $this->assertSame('✓', $result);
    }

    public function testFormatBooleanFalse(): void
    {
        $result = $this->subject->formatBoolean(false);
        $this->assertSame('✗', $result);
    }

    public function testGetLabelReturnsFallback(): void
    {
        $result = $this->subject->getLabel('nonexistent.key');
        $this->assertSame('[nonexistent.key]', $result);
    }

    public function testGetLanguageCodeWithDefault(): void
    {
        $result = $this->subject->getCurrentLanguageCode();
        $this->assertIsString($result);
    }
}
