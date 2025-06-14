<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service\Dashboard;

use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Domain\Repository\UserCourseRecordRepositoryInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Enum\UserCourseStatus;

/**
 * Builds the dashboard tabs data for a user.
 */
final class TabsBuilder
{
    public function __construct(
        private readonly UserCourseRecordRepositoryInterface $userCourseRecordRepo,
        private readonly GptTranslationServiceInterface $translationService,
    ) {
    }

    /**
     * Build tab data grouped by running and completed course instances.
     *
     * @param FrontendUser $user
     * @param array<int,\Equed\EquedLms\Domain\Model\CertificateDispatch> $latestCertificates
     * @return array<string,array<int,array<string,mixed>>>
     */
    public function build(FrontendUser $user, array $latestCertificates): array
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
                'id'               => $ciId,
                'title'            => $this->translationService->translate(
                    'dashboard.course.title',
                    ['title' => $ci->getTitle()]
                ),
                'status'           => $status,
                'progressPercent'  => $record->getProgressPercent(),
                'participantCount' => $ci->getParticipantCount(),
                'location'         => $ci->getLocation(),
                'startDate'        => $ci->getStartDate()?->format('Y-m-d') ?? '',
                'endDate'          => $ci->getEndDate()?->format('Y-m-d') ?? '',
                'badgeIcon'        => $record->hasBadge() ? $record->getBadgeIconUrl() : null,
                'certificateUrl'   => $certUrl,
            ];
        }

        return $tabs;
    }
}
