<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Service;

use Equed\EquedLms\Domain\Model\CertificateDispatch;
use Equed\EquedLms\Domain\Model\UserCourseRecord;

interface CertificateServiceInterface
{
    public function issueCertificate(UserCourseRecord $userCourseRecord): CertificateDispatch;

    public function sendCertificateNotification(CertificateDispatch $dispatch): void;
}

