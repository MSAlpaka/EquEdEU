<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Controller;

use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use Equed\EquedLms\Controller\CertificationController;
use Equed\EquedLms\Service\CertificationServiceInterface;
use TYPO3\CMS\Core\View\ViewInterface;
use Psr\Log\LoggerInterface;

final class CertificationControllerTest extends TestCase
{
    use ProphecyTrait;

    private CertificationController $subject;
    private $certificationService;
    private $logger;
    private $view;

    protected function setUp(): void
    {
        $this->certificationService = $this->prophesize(CertificationServiceInterface::class);
        $this->logger = $this->prophesize(LoggerInterface::class);
        $this->view = $this->prophesize(ViewInterface::class);

        $this->subject = new CertificationController(
            $this->certificationService->reveal(),
            $this->logger->reveal()
        );
        $this->subject->injectView($this->view->reveal());
    }

    public function testListActionAssignsCertificationsToView(): void
    {
        $certs = ['cert1', 'cert2'];
        $this->certificationService->getAllForUser()->willReturn($certs);

        $this->view->assign('certifications', $certs)->shouldBeCalled();

        $this->subject->listAction();
    }

    public function testDownloadActionLogsMissing(): void
    {
        $this->certificationService->getById(99)->willReturn(null);

        $this->logger->warning('Certification not found.', ['id' => 99])->shouldBeCalled();

        $this->subject->downloadAction(99);
    }
}
