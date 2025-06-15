<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

/**
 * Contract for mail related functionality within the extension.
 */
interface MailServiceInterface
{
    /**
     * Send a simple plain text mail.
     */
    public function sendMail(string $email, string $subject, string $body): void;

    /**
     * Inform a user that a certificate was issued.
     */
    public function sendCertificateIssuedMail(string $recipientEmail, string $certificateNumber): void;

    /**
     * Send a notification about a new QMS case.
     */
    public function sendQmsNotification(string $recipientEmail, string $caseId): void;

    /**
     * Send a reminder for an open QMS case.
     */
    public function sendQmsReminder(string $recipientEmail, string $caseId): void;

    /**
     * @param string[]    $recipients
     * @param string      $subject
     * @param string      $body
     * @param string|null $attachmentPath
     * @return void
     */
    public function sendEmail(array $recipients, string $subject, string $body, ?string $attachmentPath = null): void;
}
