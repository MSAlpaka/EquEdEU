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
    public function __construct(
        private readonly MailMessageFactoryInterface $mailFactory,
        private readonly GptTranslationServiceInterface $translationService
    ) {
    }

    /**
     * Send an email notifying the recipient that their certificate has been issued.
     *
     * @param string $recipientEmail
     * @param string $certificateNumber
     */
    public function sendCertificateIssuedMail(string $recipientEmail, string $certificateNumber): void
    {
        $subject = $this->translationService->translate(
            'email.certificate_issued.subject',
            ['certificateNumber' => $certificateNumber],
            'Your Certificate is Ready'
        );
        $body = $this->translationService->translate(
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
        $subject = $this->translationService->translate(
            'email.qms_notification.subject',
            ['caseId' => $caseId],
            'QMS Case Update'
        );
        $body = $this->translationService->translate(
            'email.qms_notification.body',
            ['caseId' => $caseId],
            'A new update is available in QMS case #{caseId}.'
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
            ->setFrom($this->translationService->translate('email.default_from', [], 'noreply@equed.eu'));

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
