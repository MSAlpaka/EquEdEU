<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\QmsCase;
use Equed\EquedLms\Service\LogService;
use Equed\EquedLms\Service\MailServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

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
        private readonly GptTranslationServiceInterface $translationService,
        string $serviceCenterEmail = 'servicecenter@equed.eu',
        string $extensionKey = 'equed_lms'
    ) {
        $this->extensionKey = $extensionKey;
        $this->serviceCenterEmail = $serviceCenterEmail;
    }

    /**
     * Escaliert einen QMS-Eintrag basierend auf den übergebenen Daten.
     */
    public function escalate(QmsCase $case): void
    {
        $subject = $this->translate(
            'qms.escalation.subject',
            ['caseId' => $case->getUid()]
        );

        $body = $this->translate(
            'qms.escalation.body',
            [
                'caseId'   => $case->getUid(),
                'issue'    => $case->getIssue(),
                'status'   => $case->getStatus(),
                'userId'   => $case->getFeUser(),
            ]
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

    /**
     * Translate a localization key using the GPT-based service with fallback.
     *
     * @param string               $key        Localization key
     * @param array<string,mixed>  $arguments  Placeholder arguments
     * @return string Translated text or key if none found
     */
    private function translate(string $key, array $arguments = []): string
    {
        if ($this->translationService->isEnabled()) {
            $translated = $this->translationService->translate(
                $key,
                $arguments,
                $this->extensionKey
            );
            if ($translated !== null && $translated !== $key) {
                return $translated;
            }
        }

        return LocalizationUtility::translate($key, $this->extensionKey, $arguments) ?? $key;
    }
}
