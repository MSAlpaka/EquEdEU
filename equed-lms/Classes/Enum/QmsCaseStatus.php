<?php

declare(strict_types=1);

namespace Equed\EquedLms\Enum;

/**
 * Status values for QmsCase entities.
 */
enum QmsCaseStatus: string
{
    case Open = 'open';
    case InProgress = 'in_progress';
    case Closed = 'closed';
}
