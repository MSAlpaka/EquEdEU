<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\UserBadge;
use Equed\EquedLms\Domain\Repository\UserBadgeRepositoryInterface;
use Psr\Cache\CacheItemPoolInterface;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Service for recognizing and awarding badges to users.
 */
final class RecognitionAwardService
{
    private const EXTENSION_KEY = 'equed_lms';

    public function __construct(
        private readonly UserBadgeRepositoryInterface $userBadgeRepository,
        private readonly PersistenceManagerInterface $persistenceManager,
        private readonly CacheItemPoolInterface $cachePool,
        private readonly GptTranslationServiceInterface $translationService
    ) {
    }

    public function qualifiesForAdvancedTitle(int $userId): bool
    {
        $cacheKey = sprintf('qualifyAdvanced_%d', $userId);
        $cacheItem = $this->cachePool->getItem($cacheKey);
        if ($cacheItem->isHit()) {
            return (bool)$cacheItem->get();
        }

        $count = $this->userBadgeRepository->countValidBadges($userId);
        $qualifies = $count >= 4;

        $cacheItem->set($qualifies);
        $this->cachePool->save($cacheItem);

        return $qualifies;
    }

    public function assignRecognitionBadge(int $userId, string $type): UserBadge
    {
        $existing = $this->userBadgeRepository->findByUserAndType($userId, $type);
        if ($existing !== null) {
            return $existing;
        }

        $badge = new UserBadge();
        $badge->setFeUserId($userId);
        $badge->setType($type);
        $badge->setTitle($this->translate("badge.{$type}.title"));
        $badge->setAwardedAt(new \DateTimeImmutable());

        $this->userBadgeRepository->add($badge);
        $this->persistenceManager->persistAll();
        $this->cachePool->deleteItem(sprintf('qualifyAdvanced_%d', $userId));

        return $badge;
    }

    private function translate(string $key, array $arguments = []): string
    {
        if ($this->translationService->isEnabled()) {
            $translated = $this->translationService->translate($key, $arguments, self::EXTENSION_KEY);
            if ($translated !== null && $translated !== $key) {
                return $translated;
            }
        }

        return LocalizationUtility::translate($key, self::EXTENSION_KEY, $arguments) ?? $key;
    }
}
