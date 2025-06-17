<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service\Dashboard;

use Equed\EquedLms\Dto\DashboardData;
use Psr\Cache\CacheItemPoolInterface;

/**
 * Handles retrieval and storage of dashboard data in cache.
 */
final class CacheManager
{
    public const CACHE_TTL_SECONDS = 600;

    public function __construct(
        private readonly CacheItemPoolInterface $cachePool,
        private int $cacheTtlSeconds = self::CACHE_TTL_SECONDS,
    ) {
    }

    public function fetch(int $userId): ?DashboardData
    {
        $item = $this->cachePool->getItem($this->key($userId));
        if ($item->isHit()) {
            /** @var DashboardData $data */
            $data = $item->get();
            return $data;
        }

        return null;
    }

    public function save(int $userId, DashboardData $data): void
    {
        $item = $this->cachePool->getItem($this->key($userId));
        $item->set($data);
        $item->expiresAfter($this->cacheTtlSeconds);
        $this->cachePool->save($item);
    }

    private function key(int $userId): string
    {
        return 'dashboard_user_' . $userId;
    }
}
