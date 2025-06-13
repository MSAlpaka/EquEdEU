<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

/**
 * Contract for mail related functionality within the extension.
 */
interface MailServiceInterface
{
    public function sendMail(string $email, string $subject, string $body): void;

    public function sendCertificateIssuedMail(string $recipientEmail, string $certificateNumber): void;

    public function sendQmsNotification(string $recipientEmail, string $caseId): void;

    public function sendQmsReminder(string $recipientEmail, string $caseId): void;

    /**
     * @param string[]    $recipients
     * @param string      $subject
     * @param string      $body
     * @param string|null $attachmentPath
     */
    public function sendEmail(array $recipients, string $subject, string $body, ?string $attachmentPath = null): void;
}
