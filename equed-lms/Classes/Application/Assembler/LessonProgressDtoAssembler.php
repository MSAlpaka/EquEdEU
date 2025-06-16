<?php

declare(strict_types=1);

namespace Equed\EquedLms\Application\Assembler;

use Equed\EquedLms\Application\Dto\LessonProgressDto;
use Equed\EquedLms\Domain\Model\LessonProgress;

final class LessonProgressDtoAssembler
{
    public static function fromEntity(LessonProgress $progress): LessonProgressDto
    {
        return new LessonProgressDto(
            $progress->getUuid(),
            $progress->getUserCourseRecord()?->getUser()?->getUid() ?? $progress->getFeUser() ?: null,
            $progress->getLesson()->getUid(),
            $progress->getProgress(),
            $progress->getStatus()->value,
            $progress->isCompleted(),
            $progress->getCompletedAt()?->format(DATE_ATOM),
            $progress->getUpdatedAt()->format(DATE_ATOM),
        );
    }
}
