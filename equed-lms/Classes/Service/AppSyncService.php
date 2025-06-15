<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Service\AppSyncServiceInterface;

/**
 * Default in-memory implementation for app sync queueing.
 */
final class AppSyncService implements AppSyncServiceInterface
{
    /**
     * @var array<int, array<int, array<string, mixed>>>
     */
    private array $queue = [];

    public function queueData(int $userId, string $type, array $payload): void
    {
        $this->queue[$userId][] = [
            'type'    => $type,
            'payload' => $payload,
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function fetchPending(int $userId): array
    {
        $records = $this->queue[$userId] ?? [];
        unset($this->queue[$userId]);

        return $records;
    }

    public function sync(): void
    {
        // Intentionally left blank; implement real sync in production.
    }
}
