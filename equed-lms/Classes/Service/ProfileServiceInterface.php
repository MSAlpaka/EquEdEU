<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

interface ProfileServiceInterface
{
    /**
     * @return array<int, mixed>
     */
    public function getCertificates(int $userId): array;

    /**
     * @return array<int, mixed>
     */
    public function getBadges(int $userId): array;

    /**
     * @return array{certificates: array<int, mixed>, badges: array<int, mixed>}
     */
    public function getProfileData(int $userId): array;
}
