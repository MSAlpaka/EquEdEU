<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\UserBadge;
use Equed\EquedLms\Domain\Repository\UserBadgeRepositoryInterface;
use Psr\Cache\CacheItemPoolInterface;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use Equed\EquedLms\Domain\Service\LanguageServiceInterface;
use Equed\EquedLms\Domain\Service\ClockInterface;

/**
 * Service for recognizing and awarding badges to users.
 */
final class RecognitionAwardService
{
    private const CACHE_TTL_SECONDS = 3600;

    public function __construct(
        private readonly UserBadgeRepositoryInterface $userBadgeRepository,
        private readonly PersistenceManagerInterface $persistenceManager,
        private readonly CacheItemPoolInterface $cachePool,
        private readonly LanguageServiceInterface $languageService,
        private readonly ClockInterface $clock,
        private int $cacheTtlSeconds = self::CACHE_TTL_SECONDS,
    ) {
    }

    /**
     * Determine whether the user qualifies for the advanced title badge.
     *
     * @param int $userId User identifier
     * @return bool True when the user qualifies
     */
    public function qualifiesForAdvancedTitle(int $userId): bool
    {
        $cacheKey = sprintf('qualifyAdvanced_%d', $userId);
        $cacheItem = $this->cachePool->getItem($cacheKey);
        if ($cacheItem->isHit()) {
            return (bool)$cacheItem->get();
        }

        $count = $this->userBadgeRepository->countValidBadges($userId);
        $qualifies = $count >= 4;

        $cacheItem->set($qualifies)->expiresAfter($this->cacheTtlSeconds);
        $this->cachePool->save($cacheItem);

        return $qualifies;
    }

    /**
     * Assign a recognition badge of the given type to a user.
     *
     * @param int    $userId User identifier
     * @param string $type   Badge type
     * @return UserBadge Newly created or existing badge entity
     */
    public function assignRecognitionBadge(int $userId, string $type): UserBadge
    {
        $existing = $this->userBadgeRepository->findByUserAndType($userId, $type);
        if ($existing !== null) {
            return $existing;
        }

        $badge = new UserBadge();
        $badge->setFeUserId($userId);
        $badge->setType($type);
        $badge->setTitle($this->languageService->translate("badge.{$type}.title"));
        $badge->setAwardedAt($this->clock->now());

        $this->userBadgeRepository->add($badge);
        $this->persistenceManager->persistAll();
        $this->cachePool->deleteItem(sprintf('qualifyAdvanced_%d', $userId));

        return $badge;
    }

}
