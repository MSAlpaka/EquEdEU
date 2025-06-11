<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Controller;

use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use Equed\EquedLms\Controller\CertificateController;
use Equed\EquedLms\Service\CertificateServiceInterface;
use Psr\Log\LoggerInterface;

final class CertificateControllerTest extends TestCase
{
    use ProphecyTrait;

    private CertificateController $subject;
    private $certificateService;
    private $logger;

    protected function setUp(): void
    {
        $this->certificateService = $this->prophesize(CertificateServiceInterface::class);
        $this->logger = $this->prophesize(LoggerInterface::class);

        $this->subject = new CertificateController(
            $this->certificateService->reveal(),
            $this->logger->reveal()
        );
    }

    public function testDownloadActionDelegatesToService(): void
    {
        $this->certificateService->streamPdfById(5)->shouldBeCalled();

        $this->subject->downloadAction(5);
    }

    public function testDownloadActionLogsWhenNotFound(): void
    {
        $this->certificateService->streamPdfById(404)->willThrow(new \RuntimeException('Not found'));

        $this->logger->error('Certificate not found.', ['id' => 404])->shouldBeCalled();

        try {
            $this->subject->downloadAction(404);
        } catch (\RuntimeException $e) {
            // handled
        }
    }

    public function testVerifyActionChecksValidity(): void
    {
        $this->certificateService->verifyCode('ABC123')->shouldBeCalled();

        $this->subject->verifyAction('ABC123');
    }
}
