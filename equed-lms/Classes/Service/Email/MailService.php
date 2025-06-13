<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service\Email;

use Equed\EquedLms\Exception\EmailException;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Service\MailServiceInterface;
use TYPO3\CMS\Core\Mail\MailMessage;

/**
 * Service for sending various notification emails.
 */
final class MailService implements MailServiceInterface
{
    private const EXTENSION_KEY = 'equed_lms';
    public function __construct(
        private readonly MailMessageFactoryInterface $mailFactory,
        private readonly GptTranslationServiceInterface $translationService
    ) {
    }

    /**
     * Translate a key using the extension localization with fallback.
     */
    private function t(string $key, array $arguments, string $fallback): string
    {
        $result = $this->translationService->translate($key, $arguments, self::EXTENSION_KEY);
        if ($result === null || str_starts_with($result, '[translation missing')) {
            foreach ($arguments as $name => $value) {
                $fallback = str_replace('{' . $name . '}', (string)$value, $fallback);
            }
            return $fallback;
        }

        return $result;
    }

    /**
     * Send an email notifying the recipient that their certificate has been issued.
     *
     * @param string $recipientEmail
     * @param string $certificateNumber
     */
    public function sendCertificateIssuedMail(string $recipientEmail, string $certificateNumber): void
    {
        $subject = $this->t(
            'email.certificate_issued.subject',
            ['certificateNumber' => $certificateNumber],
            'Your Certificate is Ready'
        );
        $body = $this->t(
            'email.certificate_issued.body',
            ['certificateNumber' => $certificateNumber],
            'Your certificate {certificateNumber} has been issued. Thank you!'
        );

        $mail = $this->prepareMail($recipientEmail, $subject, $body);
        $this->deliverMail($mail);
    }

    /**
     * Send a QMS case update notification.
     *
     * @param string $recipientEmail
     * @param string $caseId
     */
    public function sendQmsNotification(string $recipientEmail, string $caseId): void
    {
        $subject = $this->t(
            'email.qms_notification.subject',
            ['caseId' => $caseId],
            'QMS Case Update'
        );
        $body = $this->t(
            'email.qms_notification.body',
            ['caseId' => $caseId],
            'A new update is available in QMS case #{caseId}.'
        );

        $mail = $this->prepareMail($recipientEmail, $subject, $body);
        $this->deliverMail($mail);
    }

    /**
     * Send a reminder about an open QMS case.
     */
    public function sendQmsReminder(string $recipientEmail, string $caseId): void
    {
        $subject = $this->t(
            'email.qms_reminder.subject',
            ['caseId' => $caseId],
            'Reminder: QMS case #{caseId} is still open'
        );
        $body = $this->t(
            'email.qms_reminder.body',
            ['caseId' => $caseId],
            'Please review the open QMS case #{caseId}.'
        );

        $mail = $this->prepareMail($recipientEmail, $subject, $body);
        $this->deliverMail($mail);
    }

    /**
     * Send a generic email with optional attachment.
     *
     * @param string[]    $recipients
     * @param string      $subject
     * @param string      $body
     * @param string|null $attachmentPath
     */
    public function sendEmail(array $recipients, string $subject, string $body, ?string $attachmentPath = null): void
    {
        foreach ($recipients as $recipientEmail) {
            $mail = $this->prepareMail($recipientEmail, $subject, $body);

            if ($attachmentPath !== null && is_file($attachmentPath) && is_readable($attachmentPath)) {
                $mail->attachFromPath($attachmentPath);
            }

            $this->deliverMail($mail);
        }
    }

    /**
     * Send a single email.
     */
    public function sendMail(string $email, string $subject, string $body): void
    {
        $mail = $this->prepareMail($email, $subject, $body);
        $this->deliverMail($mail);
    }

    /**
     * Prepare a MailMessage with standard headers.
     */
    private function prepareMail(string $to, string $subject, string $body): MailMessage
    {
        /** @var MailMessage $mail */
        $mail = $this->mailFactory->create();
        $mail->setTo($to)
            ->setSubject($subject)
            ->setBody($body, 'text/plain')
            ->setFrom($this->t('email.default_from', [], 'noreply@equed.eu'));

        return $mail;
    }

    /**
     * Send the prepared MailMessage, throwing on failure.
     */
    private function deliverMail(MailMessage $mail): void
    {
        try {
            $mail->send();
        } catch (\Throwable $e) {
            throw new EmailException('Failed to send email', 0, $e);
        }
    }
}
// EOF
