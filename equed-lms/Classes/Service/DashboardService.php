<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use DateTimeImmutable;
use Equed\EquedLms\Domain\Service\ClockInterface;
use Psr\Cache\CacheItemPoolInterface;
use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Domain\Repository\CertificateDispatchRepositoryInterface;
use Equed\EquedLms\Domain\Repository\NotificationRepositoryInterface;
use Equed\EquedLms\Service\ProgressServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\DashboardServiceInterface;
use Equed\EquedLms\Service\Dashboard\TabsBuilder;
use Equed\EquedLms\Service\Dashboard\FilterMetadataProvider;
use Equed\EquedLms\Dto\DashboardData;

/**
 * Aggregates and prepares all data for the user dashboard,
 * implementing tabbed navigation, card metrics, filters, DataTables metadata,
 * translation fallback, feature toggles, and offline caching metadata.
 */
final class DashboardService implements DashboardServiceInterface
{
    private const CACHE_TTL_SECONDS = 600;

    public function __construct(
        private readonly CertificateDispatchRepositoryInterface $certificateRepo,
        private readonly NotificationRepositoryInterface        $notificationRepo,
        private readonly ProgressServiceInterface               $progressService,
        private readonly GptTranslationServiceInterface         $translationService,
        private readonly CacheItemPoolInterface                 $cachePool,
        private readonly bool                                   $gptAnalysisEnabled,
        private readonly ClockInterface                         $clock,
        private readonly TabsBuilder                            $tabsBuilder,
        private readonly FilterMetadataProvider                 $filterProvider,
    ) {
    }

    /**
     * Get all dashboard data for a frontend user.
     *
     * @param FrontendUser $user Frontend user model
     */
    public function getDashboardDataForUser(FrontendUser $user): DashboardData
    {
        $userId    = $user->getUid();
        $cacheKey  = 'dashboard_user_' . $userId;
        $cacheItem = $this->cachePool->getItem($cacheKey);

        if ($cacheItem->isHit()) {
            return $cacheItem->get();
        }

        $certificateList   = $this->certificateRepo->findByFeUser($user);
        $notificationList  = $this->notificationRepo->findLatestByUser($user);

        // Batch latest certificate per course instance
        $latestCertificates = [];
        foreach ($certificateList as $cert) {
            $ciId = $cert->getCourseInstance()?->getUid();
            if ($ciId === null) {
                continue;
            }
            if (!isset($latestCertificates[$ciId]) ||
                $cert->getCreatedAt() > $latestCertificates[$ciId]->getCreatedAt()
            ) {
                $latestCertificates[$ciId] = $cert;
            }
        }

        $data = new DashboardData(
            $this->buildUserData($user),
            $this->tabsBuilder->build($user, $latestCertificates),
            $this->filterProvider->getMetadata(),
            $this->progressService->getProgressDataForUser($user),
            $this->buildNotificationsData($notificationList),
            [
                'ttl'       => self::CACHE_TTL_SECONDS,
                'fetchedAt' => $this->clock->now()->format(DateTimeImmutable::ATOM),
            ],
            [
                'gptAnalysis' => $this->gptAnalysisEnabled,
            ],
        );

        $cacheItem->set($data)->expiresAfter(self::CACHE_TTL_SECONDS);
        $this->cachePool->save($cacheItem);

        return $data;
    }

    private function buildUserData(FrontendUser $user): array
    {
        $roles = [];
        foreach ($user->getUsergroup() as $group) {
            if (is_object($group) && method_exists($group, 'getTitle')) {
                $roles[] = $group->getTitle();
            }
        }

        return [
            'id'    => $user->getUid(),
            'name'  => $this->translationService->translate(
                'dashboard.user.name',
                ['name' => $user->getName()]
            ),
            'roles' => $roles,
        ];
    }


    private function buildNotificationsData(array $notifications): array
    {
        $result = [];
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
