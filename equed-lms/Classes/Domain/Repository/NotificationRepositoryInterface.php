<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Domain\Model\Notification;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

interface NotificationRepositoryInterface
{
    /**
     * @return Notification[]
     */
    public function findUnreadByUser(FrontendUser $user): array;

    /**
     * @return Notification[]
     */
    public function findLatestByUser(FrontendUser $user, int $limit = 5): array;

    /**
     * @param int $uid
     * @return Notification|null
     */
    public function findByUid(int $uid);

    /**
     * @param Notification $notification
     */
    public function add(Notification $notification): void;

    /**
     * @return QueryInterface<Notification>
     */
    public function createQuery(): QueryInterface;
}
