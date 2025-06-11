<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use DateTimeImmutable;
use Equed\EquedLms\Domain\Model\UserCourseRecord;
use Equed\EquedLms\Domain\Repository\UserCourseRecordRepository;
use Equed\EquedLms\Enum\CourseStatus;
use Equed\EquedLms\Service\CertificateServiceInterface;
use Equed\EquedLms\Service\NotificationServiceInterface;

/**
 * Service to finalize a user course record: mark validated, persist changes,
 * issue certificate and send notifications.
 */
final class CourseStatusUpdaterService
{
    public function __construct(
        private readonly CertificateServiceInterface    $certificateService,
        private readonly NotificationServiceInterface   $notificationService,
        private readonly UserCourseRecordRepository     $userCourseRecordRepository
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
        $record->setCompletionDate(new DateTimeImmutable());

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
