<?php

declare(strict_types=1);

namespace Equed\EquedLms\Enum;

/**
 * Possible status values for EventBooking entities.
 */
enum EventBookingStatus: string
{
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Cancelled = 'cancelled';
    case Attended = 'attended';
}
