<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Service\MailServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Repository\NotificationRepositoryInterface;
use Equed\EquedLms\Domain\Repository\FrontendUserRepositoryInterface;
use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Domain\Service\NotificationServiceInterface;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Handles sending notifications via email or push.
 */
final class NotificationService implements NotificationServiceInterface
{
    private const EXTENSION_KEY = 'equed_lms';

    public function __construct(
        private readonly MailServiceInterface $mailService,
        private readonly GptTranslationServiceInterface $translationService,
        private readonly NotificationRepositoryInterface $notificationRepository,
        private readonly FrontendUserRepositoryInterface $frontendUserRepository,
        private readonly PersistenceManagerInterface $persistenceManager
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

    public function sendCourseCompletedNotice(FrontendUser $user, int $courseInstanceId): void
    {
        $email = $user->getEmail();
        if ($email === '') {
            return;
        }

        $subject = $this->translate('notification.course_completed.subject', ['course' => $courseInstanceId]);
        $body    = $this->translate('notification.course_completed.body', ['course' => $courseInstanceId]);

        $this->mailService->sendMail($email, $subject, $body);
    }

    public function sendCertificateIssuedInfo(FrontendUser $user, string $qrCodeUrl): void
    {
        $email = $user->getEmail();
        if ($email === '') {
            return;
        }

        $subject = $this->translate('notification.certificate_issued.subject');
        $body    = $this->translate('notification.certificate_issued.body', ['url' => $qrCodeUrl]);

        $this->mailService->sendMail($email, $subject, $body);
    }

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
