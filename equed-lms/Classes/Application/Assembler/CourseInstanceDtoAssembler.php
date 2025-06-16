<?php

declare(strict_types=1);

namespace Equed\EquedLms\Application\Assembler;

use Equed\EquedLms\Application\Dto\CourseInstanceDto;
use Equed\EquedLms\Domain\Model\CourseInstance;

final class CourseInstanceDtoAssembler
{
    public static function fromEntity(CourseInstance $instance): CourseInstanceDto
    {
        return new CourseInstanceDto(
            (int)$instance->getUid(),
            $instance->getUuid(),
            $instance->getTitle(),
            $instance->getStartDate()?->format(DATE_ATOM),
            $instance->getEndDate()?->format(DATE_ATOM),
            $instance->getLocation(),
            $instance->getLanguage(),
            $instance->getSeatsTotal(),
            $instance->getSeatsAvailable(),
            $instance->requiresExternalExaminer(),
            $instance->isConfirmed(),
            $instance->isVisible(),
            $instance->isArchived(),
            $instance->getValidationMode()->value,
            $instance->getCourseProgram()?->getUid(),
            $instance->getInstructor()?->getUid(),
            $instance->getExternalExaminer()?->getUid(),
        );
    }
}
