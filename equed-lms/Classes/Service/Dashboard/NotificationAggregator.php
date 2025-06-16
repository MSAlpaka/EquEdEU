<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service\Dashboard;

use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Domain\Repository\NotificationRepositoryInterface;

/**
 * Aggregates dashboard notification data for a user.
 */
final class NotificationAggregator
{
    public function __construct(
        private readonly NotificationRepositoryInterface $notificationRepository,
    ) {
    }

    /**
     * Build structured notification data for the given user.
     *
     * @return array<int,array<string,mixed>>
     */
    public function aggregate(FrontendUser $user): array
    {
        $notifications = $this->notificationRepository->findLatestByUser($user);
        $result        = [];
        foreach ($notifications as $note) {
            $result[] = [
                'type'          => $note->getType(),
                'titleKey'      => $note->getTitleKey(),
                'customMessage' => $note->getCustomMessage(),
                'date'          => $note->getCreatedAt()?->format('Y-m-d H:i') ?? '',
            ];
        }

        return $result;
    }
}
