<?php

declare(strict_types=1);

namespace Equed\EquedLms\Application\Assembler;

use Equed\EquedLms\Application\Dto\CourseDto;
use Equed\EquedLms\Domain\Model\Course;

final class CourseDtoAssembler
{
    public static function fromEntity(Course $course): CourseDto
    {
        return new CourseDto(
            (int)$course->getUid(),
            $course->getTitle(),
            $course->getDescription(),
            $course->getStartDate()?->format(DATE_ATOM),
            $course->getLocation()
        );
    }
}
