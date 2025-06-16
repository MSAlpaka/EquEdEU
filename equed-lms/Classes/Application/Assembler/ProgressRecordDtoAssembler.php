<?php

declare(strict_types=1);

namespace Equed\EquedLms\Application\Assembler;

use Equed\EquedLms\Application\Dto\ProgressRecordDto;
use Equed\EquedLms\Domain\Model\UserProgressRecord;

final class ProgressRecordDtoAssembler
{
    public static function fromEntity(UserProgressRecord $record): ProgressRecordDto
    {
        return new ProgressRecordDto(
            $record->getUuid(),
            $record->getFeUser()?->getUid(),
            $record->getLesson()?->getUid(),
            $record->getStatus()->value,
            $record->getProgressPercent(),
            $record->getLastAccessedAt()?->format(DATE_ATOM),
            $record->isCompleted(),
            $record->getCompletedAt()?->format(DATE_ATOM),
        );
    }
}
