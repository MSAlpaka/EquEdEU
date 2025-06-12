<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\Notification;
use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * Repository for Notification entities.
 */
final class NotificationRepository extends Repository
{
    /**
     * Finds unread notifications for a specific instructor.
     *
     * @param FrontendUser $user
     * @return Notification[]
     */
    public function findUnreadByUser(FrontendUser $user): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd([
                $query->equals('instructor', $user),
                $query->equals('read', false),
            ])
        );

        return $query->execute()->toArray();
    }

    /**
     * Finds the latest notifications for a specific instructor.
     *
     * @param FrontendUser $user
     * @param int          $limit
     * @return Notification[]
     */
    public function findLatestByUser(FrontendUser $user, int $limit = 5): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('instructor', $user)
        );
        $query->setOrderings(['crdate' => QueryInterface::ORDER_DESCENDING]);
        $query->setLimit($limit);

        return $query->execute()->toArray();
    }

    /**
     * Find a notification by UID.
     *
     * @param int $uid
     * @return Notification|null
     */
    public function findByUid(int $uid): ?Notification
    {
        return $this->findByIdentifier($uid);
    }
}
// EOF
