<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Service\MailServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Handles sending notifications via email or push.
 */
final class NotificationService
{
    private const EXTENSION_KEY = 'equed_lms';

    public function __construct(
        private readonly MailServiceInterface $mailService,
        private readonly GptTranslationServiceInterface $translationService
    ) {
    }

    public function notifyCertifier(string $email, string $courseTitle): void
    {
        $subject = $this->translate('notification.certifier.subject', ['course' => $courseTitle]);
        $body = $this->translate('notification.certifier.body', ['course' => $courseTitle]);
        $this->mailService->sendMail($email, $subject, $body);
    }

    public function notifyInstructorOfSubmission(string $email, string $submissionId): void
    {
        $subject = $this->translate('notification.instructor.subject', ['submission' => $submissionId]);
        $body = $this->translate('notification.instructor.body', ['submission' => $submissionId]);
        $this->mailService->sendMail($email, $subject, $body);
    }

    public function notifyUserCertificateReady(string $email, string $certificateNumber): void
    {
        $subject = $this->translate('notification.user.subject', ['certificate' => $certificateNumber]);
        $body = $this->translate('notification.user.body', ['certificate' => $certificateNumber]);
        $this->mailService->sendMail($email, $subject, $body);
    }

    private function translate(string $key, array $arguments = []): string
    {
        $translated = $this->translationService->isEnabled()
            ? $this->translationService->translate($key, $arguments, self::EXTENSION_KEY)
            : null;

        if ($translated !== null && $translated !== $key) {
            return $translated;
        }

        return LocalizationUtility::translate($key, self::EXTENSION_KEY, $arguments) ?? $key;
    }
}
