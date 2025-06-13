<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Service\TranslatedLoggerTrait;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Service\LogService;
use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use Psr\Log\LoggerInterface;

class TranslatedLoggerTraitTest extends TestCase
{
    use ProphecyTrait;

    public function testLogsTranslatedMessage(): void
    {
        $translator = $this->prophesize(GptTranslationServiceInterface::class);
        $translator->translate('key', ['foo' => 'bar'])->willReturn('msg');

        $logger = $this->prophesize(LoggerInterface::class);
        $logService = new LogService($logger->reveal());

        $object = new class ($translator->reveal(), $logService) {
            use TranslatedLoggerTrait;
            public function __construct($t, $l) { $this->injectTranslatedLogger($t, $l); }
            public function trigger(): void { $this->logTranslatedError('key', ['foo' => 'bar']); }
        };

        $logger->error('msg', [])->shouldBeCalled();

        $object->trigger();
    }

    public function testLogsKeyWhenTranslationMissing(): void
    {
        $translator = $this->prophesize(GptTranslationServiceInterface::class);
        $translator->translate('key')->willReturn(null);

        $logger = $this->prophesize(LoggerInterface::class);
        $logService = new LogService($logger->reveal());

        $object = new class ($translator->reveal(), $logService) {
            use TranslatedLoggerTrait;
            public function __construct($t, $l) { $this->injectTranslatedLogger($t, $l); }
            public function trigger(): void { $this->logTranslatedError('key'); }
        };

        $logger->error('key', [])->shouldBeCalled();

        $object->trigger();
    }
}
