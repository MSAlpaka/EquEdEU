<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Repository\CertificateRepositoryInterface;
use Equed\EquedLms\Domain\Repository\BadgeRepositoryInterface;

/**
 * Service for retrieving profile related data such as certificates and badges.
 */
final class ProfileService implements ProfileServiceInterface
{
    public function __construct(
        private readonly CertificateRepositoryInterface $certificateRepository,
        private readonly BadgeRepositoryInterface $badgeRepository,
    ) {
    }

    /**
     * Get all certificates for the specified user.
     *
     * @param int $userId FE user ID
     * @return array<int, mixed>
     */
    public function getCertificates(int $userId): array
    {
        return $this->certificateRepository->findByUser($userId);
    }

    /**
     * Get all badges for the specified user.
     *
     * @param int $userId FE user ID
     * @return array<int, mixed>
     */
    public function getBadges(int $userId): array
    {
        return $this->badgeRepository->findByUser($userId);
    }

    /**
     * Retrieve both certificates and badges for the user.
     *
     * @param int $userId FE user ID
     * @return array{certificates: array<int, mixed>, badges: array<int, mixed>}
     */
    public function getProfileData(int $userId): array
    {
        return [
            'certificates' => $this->getCertificates($userId),
            'badges'       => $this->getBadges($userId),
        ];
    }
}

