<?php

declare(strict_types=1);

namespace Equed\EquedLms\Enum;

/**
 * Status values for external system sync operations.
 */
enum ExternalSyncStatus: string
{
    case Ok = 'ok';
    case Failed = 'failed';
    case Pending = 'pending';
}

