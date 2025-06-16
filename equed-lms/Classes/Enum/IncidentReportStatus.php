<?php

declare(strict_types=1);

namespace Equed\EquedLms\Enum;

/**
 * Status values for incident reports.
 */
enum IncidentReportStatus: string
{
    case Open = 'open';
    case Review = 'review';
    case Closed = 'closed';
    case Escalated = 'escalated';
}

