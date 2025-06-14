<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Domain\Model\QmsCase;
use Equed\EquedLms\Domain\Service\LanguageServiceInterface;
use Equed\EquedLms\Service\LogService;
use Equed\EquedLms\Service\MailServiceInterface;
use Equed\EquedLms\Service\QmsEscalationService;
use Equed\EquedLms\Enum\QmsCaseStatus;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class QmsEscalationServiceTest extends TestCase
{
    use ProphecyTrait;

    private QmsEscalationService $subject;
    private $mail;
    private $language;

    protected function setUp(): void
    {
        $logger = $this->prophesize(LoggerInterface::class);
        $logService = new LogService($logger->reveal());

        $this->mail = $this->prophesize(MailServiceInterface::class);
        $this->language = $this->prophesize(LanguageServiceInterface::class);

        $this->subject = new QmsEscalationService(
            $logService,
            $this->mail->reveal(),
            $this->language->reveal(),
            'center@example.com',
            'equed_lms'
        );
    }

    public function testEscalateSendsMailWithTranslations(): void
    {
        $case = $this->prophesize(QmsCase::class);
        $case->getUid()->willReturn(5);
        $case->getIssue()->willReturn('issue');
        $case->getStatus()->willReturn(QmsCaseStatus::Open);
        $case->getFeUser()->willReturn(42);

        $this->language->translate('qms.escalation.subject', ['caseId' => 5], 'equed_lms')->willReturn('Subj');
        $this->language->translate('qms.escalation.body', [
            'caseId' => 5,
            'issue' => 'issue',
            'status' => QmsCaseStatus::Open->value,
            'userId' => 42,
        ], 'equed_lms')->willReturn('Body');

        $this->mail->sendMail('center@example.com', 'Subj', 'Body')->shouldBeCalled();

        $this->subject->escalate($case->reveal());
    }
}
