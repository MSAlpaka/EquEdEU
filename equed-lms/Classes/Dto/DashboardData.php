<?php

declare(strict_types=1);

namespace Equed\EquedLms\Dto;

/**
 * Data Transfer Object holding dashboard data for a user.
 */
final class DashboardData implements \JsonSerializable
{
    /**
     * @param array<string,mixed>                             $user
     * @param array<string,array<int,array<string,mixed>>>    $tabs
     * @param array<string,mixed>                             $filters
     * @param array<string,mixed>                             $progress
     * @param array<int,array<string,mixed>>                  $notifications
     * @param array<string,mixed>                             $cacheMeta
     * @param array<string,mixed>                             $features
     */
    public function __construct(
        private readonly array $user,
        private readonly array $tabs,
        private readonly array $filters,
        private readonly array $progress,
        private readonly array $notifications,
        private readonly array $cacheMeta,
        private readonly array $features,
    ) {
    }

    /** @return array<string,mixed> */
    public function getUser(): array
    {
        return $this->user;
    }

    /** @return array<string,array<int,array<string,mixed>>> */
    public function getTabs(): array
    {
        return $this->tabs;
    }

    /** @return array<string,mixed> */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /** @return array<string,mixed> */
    public function getProgress(): array
    {
        return $this->progress;
    }

    /** @return array<int,array<string,mixed>> */
    public function getNotifications(): array
    {
        return $this->notifications;
    }

    /** @return array<string,mixed> */
    public function getCacheMeta(): array
    {
        return $this->cacheMeta;
    }

    /** @return array<string,mixed> */
    public function getFeatures(): array
    {
        return $this->features;
    }

    public function jsonSerialize(): array
    {
        return [
            'user'          => $this->user,
            'tabs'          => $this->tabs,
            'filters'       => $this->filters,
            'progress'      => $this->progress,
            'notifications' => $this->notifications,
            'cacheMeta'     => $this->cacheMeta,
            'features'      => $this->features,
        ];
    }
}
