<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Service\DocumentService;
use Equed\EquedLms\Exception\InvalidFileTypeException;
use PHPUnit\Framework\TestCase;

final class DocumentServiceTest extends TestCase
{
    public function testGenerateDownloadLinkWithAllowedExtension(): void
    {
        $service = new DocumentService('https://files.example.com', 'https://tpl.example.com');
        $result = $service->generateDownloadLink('invoice.pdf');
        $this->assertSame('https://files.example.com/invoice.pdf', $result);
    }

    public function testGenerateDownloadLinkThrowsOnInvalidExtension(): void
    {
        $this->expectException(InvalidFileTypeException::class);
        $service = new DocumentService('https://files.example.com', 'https://tpl.example.com');
        $service->generateDownloadLink('malware.exe');
    }

    public function testGetTemplatePathSanitizesName(): void
    {
        $service = new DocumentService('https://files.example.com', 'https://tpl.example.com');
        $result = $service->getTemplatePath('Danger 123!');
        $this->assertSame('https://tpl.example.com/Danger123.pdf', $result);
    }

}
