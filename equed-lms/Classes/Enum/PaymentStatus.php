<?php

declare(strict_types=1);

namespace Equed\EquedLms\Enum;

/**
 * Possible status values for payment transactions.
 */
enum PaymentStatus: string
{
    case Pending = 'pending';
    case Successful = 'successful';
    case Failed = 'failed';
}
