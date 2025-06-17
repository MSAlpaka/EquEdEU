<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use DateTimeImmutable;
use Equed\EquedLms\Domain\Service\ClockInterface;
use Equed\EquedLms\Service\Dashboard\CacheManager;
use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Domain\Repository\CertificateDispatchRepositoryInterface;
use Equed\EquedLms\Service\ProgressServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\DashboardServiceInterface;
use Equed\EquedLms\Service\Dashboard\TabsBuilder;
use Equed\EquedLms\Service\Dashboard\FilterMetadataProvider;
use Equed\EquedLms\Service\Dashboard\NotificationAggregator;
use Equed\EquedLms\Dto\DashboardData;

/**
 * Aggregates and prepares all data for the user dashboard,
 * implementing tabbed navigation, card metrics, filters, DataTables metadata,
 * translation fallback, feature toggles, and offline caching metadata.
 */
final class DashboardService implements DashboardServiceInterface
{

    public function __construct(
        private readonly CertificateDispatchRepositoryInterface $certificateRepo,
        private readonly ProgressServiceInterface               $progressService,
        private readonly GptTranslationServiceInterface         $translationService,
        private readonly bool                                   $gptAnalysisEnabled,
        private readonly ClockInterface                         $clock,
        private readonly TabsBuilder                            $tabsBuilder,
        private readonly FilterMetadataProvider                 $filterProvider,
        private readonly NotificationAggregator                 $notificationAggregator,
        private readonly CacheManager                           $cacheManager,
    ) {
    }

    /**
     * Get all dashboard data for a frontend user.
     *
     * @param FrontendUser $user Frontend user model
     */
    public function getDashboardDataForUser(FrontendUser $user): DashboardData
    {
        $userId = $user->getUid();
        $cached = $this->cacheManager->fetch($userId);

        if ($cached !== null) {
            return $cached;
        }

        $certificateList = $this->certificateRepo->findByFeUser($user);

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
            $this->notificationAggregator->aggregate($user),
            [
                'ttl'       => CacheManager::CACHE_TTL_SECONDS,
                'fetchedAt' => $this->clock->now()->format(DateTimeImmutable::ATOM),
            ],
            [
                'gptAnalysis' => $this->gptAnalysisEnabled,
            ],
        );

        $this->cacheManager->save($userId, $data);

        return $data;
    }

    private function buildUserData(FrontendUser $user): array
    {
        $roles = [];
        foreach ($user->getUsergroup() as $group) {
            $roles[] = $group->getTitle();
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
}

