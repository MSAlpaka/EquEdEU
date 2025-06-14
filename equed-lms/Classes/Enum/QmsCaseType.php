<?php

declare(strict_types=1);

namespace Equed\EquedLms\Enum;

/**
 * Types of QmsCase.
 */
enum QmsCaseType: string
{
    case Violation = 'violation';
    case Complaint = 'complaint';
    case Audit = 'audit';
}
