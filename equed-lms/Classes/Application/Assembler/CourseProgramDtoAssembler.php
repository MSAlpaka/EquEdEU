<?php

declare(strict_types=1);

namespace Equed\EquedLms\Application\Assembler;

use Equed\EquedLms\Application\Dto\CourseProgramDto;
use Equed\EquedLms\Domain\Model\CourseProgram;

final class CourseProgramDtoAssembler
{
    public static function fromEntity(CourseProgram $program): CourseProgramDto
    {
        return new CourseProgramDto(
            (int)$program->getUid(),
            $program->getUuid(),
            $program->getTitle(),
            $program->getTitleKey(),
            $program->getDescription(),
            $program->getDescriptionKey(),
            $program->getCategory(),
            $program->getAvailableFrom()->format(DATE_ATOM),
            $program->isVisible(),
            $program->isArchived(),
            $program->getBadgeIcon()?->getOriginalResource()->getPublicUrl(),
            $program->requiresExternalExaminer(),
            $program->certifierMustValidate(),
            $program->isRecertificationRequired(),
            $program->getRecertificationIntervalYears(),
            $program->isVisibleInCatalog(),
        );
    }
}
