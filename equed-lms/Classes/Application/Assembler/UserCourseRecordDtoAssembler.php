<?php

declare(strict_types=1);

namespace Equed\EquedLms\Application\Assembler;

use Equed\EquedLms\Application\Dto\UserCourseRecordDto;
use Equed\EquedLms\Domain\Model\UserCourseRecord;

final class UserCourseRecordDtoAssembler
{
    public static function fromEntity(UserCourseRecord $record): UserCourseRecordDto
    {
        return new UserCourseRecordDto(
            (int)$record->getUid(),
            $record->getUuid(),
            $record->getCourseInstance()->getUid(),
            $record->getUser()->getUid(),
            $record->getAttemptNumber(),
            $record->getEnrolledAt()?->format(DATE_ATOM),
            $record->getCompletedAt()?->format(DATE_ATOM),
            $record->getRevokedAt()?->format(DATE_ATOM),
            $record->getCertificateNumber(),
            $record->getCertificateHash(),
            $record->getBadgeLevel()->value,
            $record->getStatus()->value,
            $record->isFinalized(),
            $record->isValidatedByCertifier(),
            $record->getCertificateIssuedAt()?->format(DATE_ATOM),
            $record->getProgressPercent(),
            $record->getLastActivity()?->format(DATE_ATOM),
            $record->isExternalCertificateFlag(),
            $record->getCreatedAt()->format(DATE_ATOM),
            $record->getUpdatedAt()->format(DATE_ATOM),
        );
    }
}
