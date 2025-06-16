<?php

declare(strict_types=1);

namespace Equed\EquedLms\Enum;

/**
 * Status values for user progress records.
 */
enum ProgressRecordStatus: string
{
    case Incomplete = 'incomplete';
    case Complete = 'complete';
    case Passed = 'passed';
}

