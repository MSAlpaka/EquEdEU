<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use Equed\EquedLms\Service\LogService;
use Psr\Log\LoggerInterface;

class LogServiceTest extends TestCase
{
    use ProphecyTrait;

    private LogService $subject;
    private $logger;

    protected function setUp(): void
    {
        $this->logger = $this->prophesize(LoggerInterface::class);
        $this->subject = new LogService(
            $this->logger->reveal()
        );
    }

    public function testSanitizesContextForAllLevels(): void
    {
        $context = [
            'userId' => 42,
            'email' => 'test@example.com',
            'other' => 'keep',
            'nested' => ['instructorId' => 99],
        ];

        $expected = [
            'userId' => sha1('42'),
            'email' => sha1('test@example.com'),
            'other' => 'keep',
            'nested' => ['instructorId' => sha1('99')],
        ];

        $this->logger->info('msg', $expected)->shouldBeCalled();
        $this->logger->warning('msg', $expected)->shouldBeCalled();
        $this->logger->error('msg', $expected)->shouldBeCalled();

        $this->subject->logInfo('msg', $context);
        $this->subject->logWarning('msg', $context);
        $this->subject->logError('msg', $context);
    }
}
