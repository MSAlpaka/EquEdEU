<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use DateTimeImmutable;
use Equed\EquedLms\Domain\Service\ClockInterface;
use Psr\Cache\CacheItemPoolInterface;
use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Domain\Repository\UserCourseRecordRepository;
use Equed\EquedLms\Domain\Repository\CourseInstanceRepositoryInterface;
use Equed\EquedLms\Domain\Repository\CertificateDispatchRepositoryInterface;
use Equed\EquedLms\Domain\Repository\NotificationRepositoryInterface;
use Equed\EquedLms\Service\ProgressServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\DashboardServiceInterface;
use Equed\EquedLms\Enum\UserCourseStatus;

/**
 * Aggregates and prepares all data for the user dashboard,
 * implementing tabbed navigation, card metrics, filters, DataTables metadata,
 * translation fallback, feature toggles, and offline caching metadata.
 */
final class DashboardService implements DashboardServiceInterface
{
    private const CACHE_TTL_SECONDS = 600;

    public function __construct(
        private readonly UserCourseRecordRepository    $userCourseRecordRepo,
        private readonly CourseInstanceRepositoryInterface      $courseInstanceRepo,
        private readonly CertificateDispatchRepositoryInterface $certificateRepo,
        private readonly NotificationRepositoryInterface        $notificationRepo,
        private readonly ProgressServiceInterface               $progressService,
        private readonly GptTranslationServiceInterface                  $translationService,
        private readonly CacheItemPoolInterface                 $cachePool,
        private readonly bool                                   $gptAnalysisEnabled,
        private readonly ClockInterface                         $clock
    ) {
    }

    /**
     * Get all dashboard data for a frontend user.
     *
     * @param FrontendUser $user Frontend user model
     * @return array<string,mixed> Dashboard payload
     */
    public function getDashboardDataForUser(FrontendUser $user): array
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

        $data = [
            'user'          => $this->buildUserData($user),
            'tabs'          => $this->buildTabsData($user, $latestCertificates),
            'filters'       => $this->buildFilterMetadata(),
            'progress'      => $this->progressService->getProgressDataForUser($user),
            'notifications' => $this->buildNotificationsData($notificationList),
            'cacheMeta'     => [
                'ttl'       => self::CACHE_TTL_SECONDS,
                'fetchedAt' => $this->clock->now()->format(DateTimeImmutable::ATOM),
            ],
            'features'      => [
                'gptAnalysis' => $this->gptAnalysisEnabled,
            ],
        ];

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

    private function buildTabsData(FrontendUser $user, array $latestCertificates): array
    {
        $records = $this->userCourseRecordRepo->findByUser($user);
        $tabs    = ['running' => [], 'completed' => []];

        foreach ($records as $record) {
            $ci     = $record->getCourseInstance();
            $status = $record->getStatus();
            $tabKey = match ($status) {
                UserCourseStatus::Validated, UserCourseStatus::Passed => 'completed',
                default                                            => 'running',
            };
            $ciId   = $ci->getUid();
            $certUrl = $latestCertificates[$ciId]?->getQrCodeUrl() ?? null;

            $tabs[$tabKey][] = [
                'id'              => $ciId,
                'title'           => $this->translationService->translate(
                    'dashboard.course.title',
                    ['title' => $ci->getTitle()]
                ),
                'status'          => $status,
                'progressPercent' => $record->getProgressPercent(),
                'participantCount' => $ci->getParticipantCount(),
                'location'        => $ci->getLocation(),
                'startDate'       => $ci->getStartDate()?->format('Y-m-d') ?? '',
                'endDate'         => $ci->getEndDate()?->format('Y-m-d') ?? '',
                'badgeIcon'       => $record->hasBadge() ? $record->getBadgeIconUrl() : null,
                'certificateUrl'  => $certUrl,
            ];
        }

        return $tabs;
    }

    private function buildFilterMetadata(): array
    {
        return [
            'theme'       => $this->courseInstanceRepo->findDistinctField('theme'),
            'language'    => $this->courseInstanceRepo->findDistinctField('language'),
            'badgeStatus' => $this->userCourseRecordRepo->findDistinctField('badgeStatus'),
            'eqfLevel'    => $this->courseInstanceRepo->findDistinctField('eqfLevel'),
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
