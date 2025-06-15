<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Service\MailServiceInterface;
use Equed\EquedLms\Domain\Service\LanguageServiceInterface;
use Equed\EquedLms\Domain\Repository\NotificationRepositoryInterface;
use Equed\EquedLms\Domain\Repository\FrontendUserRepositoryInterface;
use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Domain\Service\NotificationServiceInterface;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;

/**
 * Handles sending notifications via email or push.
 */
final class NotificationService implements NotificationServiceInterface
{

    public function __construct(
        private readonly MailServiceInterface $mailService,
        private readonly LanguageServiceInterface $languageService,
        private readonly NotificationRepositoryInterface $notificationRepository,
        private readonly FrontendUserRepositoryInterface $frontendUserRepository,
        private readonly PersistenceManagerInterface $persistenceManager
    ) {
    }

    /**
     * Send a notification e-mail to a user.
     *
     * @param FrontendUser $user    Recipient user
     * @param string       $subject Mail subject
     * @param string       $body    Mail body
     * @return void
     */
    public function notify(FrontendUser $user, string $subject, string $body): void
    {
        $email = $user->getEmail();
        if ($email === '') {
            return;
        }

        $this->mailService->sendMail($email, $subject, $body);
    }

    /**
     * Inform a certifier about a course they need to review.
     *
     * @param string $email       Recipient address
     * @param string $courseTitle Course title
     * @return void
     */
    public function notifyCertifier(string $email, string $courseTitle): void
    {
        $subject = $this->languageService->translate('notification.certifier.subject', ['course' => $courseTitle]);
        $body = $this->languageService->translate('notification.certifier.body', ['course' => $courseTitle]);
        $this->mailService->sendMail($email, $subject, $body);
    }

    /**
     * Notify an instructor about a pending submission.
     *
     * @param string $email        Recipient address
     * @param string $submissionId Submission identifier
     * @return void
     */
    public function notifyInstructorOfSubmission(string $email, string $submissionId): void
    {
        $subject = $this->languageService->translate('notification.instructor.subject', ['submission' => $submissionId]);
        $body = $this->languageService->translate('notification.instructor.body', ['submission' => $submissionId]);
        $this->mailService->sendMail($email, $subject, $body);
    }

    /**
     * Inform a user that their certificate is ready for download.
     *
     * @param string $email            Recipient address
     * @param string $certificateNumber Certificate number
     * @return void
     */
    public function notifyUserCertificateReady(string $email, string $certificateNumber): void
    {
        $subject = $this->languageService->translate('notification.user.subject', ['certificate' => $certificateNumber]);
        $body = $this->languageService->translate('notification.user.body', ['certificate' => $certificateNumber]);
        $this->mailService->sendMail($email, $subject, $body);
    }

    /**
     * Send a notice that a course has been completed.
     *
     * @param FrontendUser $user            Recipient user
     * @param int          $courseInstanceId Course instance UID
     * @return void
     */
    public function sendCourseCompletedNotice(FrontendUser $user, int $courseInstanceId): void
    {
        $email = $user->getEmail();
        if ($email === '') {
            return;
        }

        $subject = $this->languageService->translate('notification.course_completed.subject', ['course' => $courseInstanceId]);
        $body    = $this->languageService->translate('notification.course_completed.body', ['course' => $courseInstanceId]);

        $this->mailService->sendMail($email, $subject, $body);
    }

    /**
     * Send certificate issued information with QR code link.
     *
     * @param FrontendUser $user      Recipient user
     * @param string       $qrCodeUrl QR code URL
     * @return void
     */
    public function sendCertificateIssuedInfo(FrontendUser $user, string $qrCodeUrl): void
    {
        $email = $user->getEmail();
        if ($email === '') {
            return;
        }

        $subject = $this->languageService->translate('notification.certificate_issued.subject');
        $body    = $this->languageService->translate('notification.certificate_issued.body', ['url' => $qrCodeUrl]);

        $this->mailService->sendMail($email, $subject, $body);
    }

    /**
     * Retrieve notifications for the given user.
     *
     * @param int $userId Frontend user identifier
     * @return array<int, \Equed\EquedLms\Domain\Model\Notification>
     */
    public function getNotificationsForUser(int $userId): array
    {
        $query = $this->frontendUserRepository->createQuery();
        $query->matching($query->equals('uid', $userId));
        $user = $query->execute()->getFirst();
        if (! $user instanceof FrontendUser) {
            return [];
        }

        return $this->notificationRepository->findLatestByUser($user);
    }

    /**
     * Mark a notification as read for the given user.
     *
     * @param int $userId         User identifier
     * @param int $notificationId Notification UID
     * @return void
     */
    public function markAsRead(int $userId, int $notificationId): void
    {
        $notification = $this->notificationRepository->findByUid($notificationId);
        if ($notification === null) {
            return;
        }

        if ($notification->getRecipient()?->getUid() !== $userId) {
            return;
        }

        $notification->setIsRead(true);
        $this->notificationRepository->update($notification);
        $this->persistenceManager->persistAll();
    }

}
