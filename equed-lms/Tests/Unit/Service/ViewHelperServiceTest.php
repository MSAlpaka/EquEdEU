<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Service\ViewHelperService;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\TranslatorInterface;
use PHPUnit\Framework\TestCase;

class ViewHelperServiceTest extends TestCase
{
    public function testBadgeLabelFallsBackToTranslator(): void
    {
        $gpt = $this->createMock(GptTranslationServiceInterface::class);
        $gpt->method('isEnabled')->willReturn(false);

        $translator = $this->createMock(TranslatorInterface::class);
        $translator->expects($this->once())
            ->method('translate')
            ->with('badge.test.label', [], 'equed_lms')
            ->willReturn('Test');

        $service = new ViewHelperService($gpt, $translator);

        $this->assertSame('Test', $service->badgeLabel('test'));
    }
}
