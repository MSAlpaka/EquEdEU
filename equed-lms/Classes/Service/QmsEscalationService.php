<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\QmsCase;
use Equed\EquedLms\Service\LogService;
use Equed\EquedLms\Service\MailServiceInterface;
use Equed\EquedLms\Domain\Service\LanguageServiceInterface;

/**
 * Service to escalate QMS cases via email.
 */
final class QmsEscalationService
{
    private readonly string $extensionKey;
    private readonly string $serviceCenterEmail;

    public function __construct(
        private readonly LogService $logService,
        private readonly MailServiceInterface $mailService,
        private readonly LanguageServiceInterface $languageService,
        string $serviceCenterEmail = 'servicecenter@equed.eu',
        string $extensionKey = 'equed_lms'
    ) {
        $this->extensionKey = $extensionKey;
        $this->serviceCenterEmail = $serviceCenterEmail;
    }

    /**
     * Escaliert einen QMS-Eintrag basierend auf den übergebenen Daten.
     *
     * @return void
     */
    public function escalate(QmsCase $case): void
    {
        $subject = $this->languageService->translate(
            'qms.escalation.subject',
            ['caseId' => $case->getUid()],
            $this->extensionKey
        );

        $body = $this->languageService->translate(
            'qms.escalation.body',
            [
                'caseId' => $case->getUid(),
                'issue'  => $case->getIssue(),
                'status' => $case->getStatus(),
                'userId' => $case->getFeUser(),
            ],
            $this->extensionKey
        );

        $this->mailService->sendMail(
            $this->serviceCenterEmail,
            $subject,
            $body
        );

        $this->logService->logInfo(
            'Escalated QMS case to Service Center',
            ['caseId' => $case->getUid()]
        );
    }

}
