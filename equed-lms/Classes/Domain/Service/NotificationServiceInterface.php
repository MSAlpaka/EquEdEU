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
}
