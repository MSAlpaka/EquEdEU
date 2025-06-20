<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Service\ClockInterface;
use Equed\EquedLms\Domain\Model\CertificateDispatch;
use Equed\EquedLms\Domain\Model\UserCourseRecord;
use Equed\EquedLms\Domain\Repository\CertificateDispatchRepositoryInterface;
use Equed\EquedLms\Factory\CertificateDispatchFactoryInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\NotificationServiceInterface;
use Equed\EquedLms\Domain\Service\CertificateServiceInterface;

final class CertificateService implements CertificateServiceInterface
{
    private string $qrCodeBaseUrl;

    public function __construct(
        private readonly CertificateDispatchRepositoryInterface $certificateDispatchRepository,
        private readonly CertificateDispatchFactoryInterface $dispatchFactory,
        private readonly GptTranslationServiceInterface $translationService,
        private readonly NotificationServiceInterface $notificationService,
        private readonly ClockInterface $clock,
        string $qrCodeBaseUrl
    ) {
        $this->qrCodeBaseUrl = rtrim($qrCodeBaseUrl, '/') . '/';
    }

    /**
     * Issue a certificate for the given user course record if none exists yet.
     *
     * @param UserCourseRecord $userCourseRecord Course participation record
     * @return CertificateDispatch Newly created or existing dispatch entity
     */
    public function issueCertificate(UserCourseRecord $userCourseRecord): CertificateDispatch
    {
        $existing = $this->certificateDispatchRepository->findByUserCourseRecord($userCourseRecord);

        if (null !== $existing) {
            return $existing;
        }

        $qrCodeUrl = $this->generateQrCodeUrl($userCourseRecord);

        $dispatch = $this->dispatchFactory->createFromUserCourseRecord(
            $userCourseRecord,
            'pdf',
            $qrCodeUrl
        );

        $this->certificateDispatchRepository->add($dispatch);

        return $dispatch;
    }

    /**
     * Build an absolute QR code URL for the certificate.
     *
     * @param UserCourseRecord|CertificateDispatch $source Source entity
     * @return string QR code URL
     */
    private function generateQrCodeUrl(UserCourseRecord|CertificateDispatch $source): string
    {
        $userId = $source->getFeUser()?->getUid() ?? 0;
        $timestamp = $this->clock->now()->format('YmdHis');

        return sprintf('%s%s/%s', $this->qrCodeBaseUrl, $userId, $timestamp);
    }

    /**
     * Send a notification to the user that a certificate was issued.
     *
     * @param CertificateDispatch $dispatch Certificate dispatch record
     * @return void
     */
    public function sendCertificateNotification(CertificateDispatch $dispatch): void
    {
        $subject = (string)$this->translationService->translate(
            'certificate.notification.subject',
            ['course' => $dispatch->getCourseInstance()->getTitle()]
        );

        $body = (string)$this->translationService->translate(
            'certificate.notification.body',
            [
                'name' => $dispatch->getFeUser()?->getName() ?? '',
                'qrCodeUrl' => $dispatch->getQrCodeUrl()
            ]
        );
        $feUser = $dispatch->getFeUser();
        if ($feUser !== null) {
            $this->notificationService->notify($feUser, $subject, $body);
        }
    }
}

