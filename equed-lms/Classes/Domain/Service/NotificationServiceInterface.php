<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Service;

interface NotificationServiceInterface
{
    /**
     * @return array<int, mixed>
     */
    public function getNotificationsForUser(int $userId): array;

    public function markAsRead(int $userId, int $notificationId): void;

    public function notify(\Equed\EquedLms\Domain\Model\FrontendUser $user, string $subject, string $body): void;

    public function sendCourseCompletedNotice(\Equed\EquedLms\Domain\Model\FrontendUser $user, int $courseInstanceId): void;

    public function sendCertificateIssuedInfo(\Equed\EquedLms\Domain\Model\FrontendUser $user, string $qrCodeUrl): void;
}
