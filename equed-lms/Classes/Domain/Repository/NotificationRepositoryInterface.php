<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Domain\Model\Notification;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

interface NotificationRepositoryInterface
{
    /**
     * @param FrontendUser $user
     * @return Notification[]
     */
    public function findUnreadByUser(FrontendUser $user): array;

    /**
     * @param FrontendUser $user
     * @param int $limit
     * @return Notification[]
     */
    public function findLatestByUser(FrontendUser $user, int $limit = 5): array;

    /**
     * Find a notification by UID.
     *
     * @param int $uid
     * @return Notification|null
     */
    public function findByUid(int $uid): ?Notification;

    /**
     * @param Notification $notification
     * @return void
     */
    public function add(Notification $notification): void;

    /**
     * @return QueryInterface<Notification>
     */
    public function createQuery(): QueryInterface;
}
