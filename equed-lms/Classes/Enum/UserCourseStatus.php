<?php

declare(strict_types=1);

namespace Equed\EquedLms\Enum;

/**
 * Status values for UserCourseRecord entities.
 */
enum UserCourseStatus: string
{
    case InProgress = 'in_progress';
    case Failed = 'failed';
    case Passed = 'passed';
    case Validated = 'validated';
}
