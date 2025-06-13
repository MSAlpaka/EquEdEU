<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Service\ClockInterface;
use Equed\EquedLms\Domain\Model\UserCourseRecord;
use Equed\EquedLms\Domain\Repository\UserCourseRecordRepositoryInterface;
use Equed\EquedLms\Enum\CourseStatus;
use Equed\EquedLms\Service\CertificateService;
use Equed\EquedLms\Service\NotificationService;

/**
 * Service to finalize a user course record: mark validated, persist changes,
 * issue certificate and send notifications.
 */
final class CourseStatusUpdaterService
{
    public function __construct(
        private readonly CertificateService    $certificateService,
        private readonly NotificationService   $notificationService,
        private readonly UserCourseRecordRepositoryInterface $userCourseRecordRepository,
        private readonly ClockInterface        $clock
    ) {
    }

    /**
     * Finalize the given UserCourseRecord.
     *
     * @param UserCourseRecord $record
     */
    public function finalize(UserCourseRecord $record): void
    {
        $record->setStatus(CourseStatus::Validated->value);
        $record->setCompletionDate($this->clock->now());

        $this->userCourseRecordRepository->update($record);

        $certificate = $this->certificateService->issueCertificate($record);

        $feUser = $record->getFeUser();
        $courseInstance = $record->getCourseInstance();

        $ciUid = (int)$courseInstance->getUid();
        $this->notificationService->sendCourseCompletedNotice(
            $feUser,
            $ciUid
        );

        $this->notificationService->sendCertificateIssuedInfo(
            $feUser,
            $certificate->getQrCodeUrl()
        );
    }
}
