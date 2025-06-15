<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Service;

/**
 * Handles queuing and retrieval of app sync data.
 */
interface AppSyncServiceInterface
{
    /**
     * Queue data for later synchronization with the mobile app.
     *
     * @param int   $userId  Frontend user identifier
     * @param string $type    Data type identifier
     * @param array<string, mixed> $payload Data payload
     */
    public function queueData(int $userId, string $type, array $payload): void;

    /**
     * Fetch queued sync data for the given user.
     *
     * @param int $userId Frontend user identifier
     *
     * @return array<int, array<string, mixed>>
     */
    public function fetchPending(int $userId): array;

    /**
     * Execute pending synchronization tasks.
     */
    public function sync(): void;
}
