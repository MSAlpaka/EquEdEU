<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\FrontendUser;

interface NotificationServiceInterface
{
    public function notify(FrontendUser $user, string $subject, string $body): void;
    public function sendCourseCompletedNotice(FrontendUser $user, int $courseInstanceId): void;
    public function sendCertificateIssuedInfo(FrontendUser $user, string $qrCodeUrl): void;
}
