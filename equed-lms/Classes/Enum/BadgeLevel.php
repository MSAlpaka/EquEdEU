<?php

declare(strict_types=1);

namespace Equed\EquedLms\Enum;

/**
 * Defines available badge levels.
 */
enum BadgeLevel: string
{
    case None = 'none';
    case Bronze = 'bronze';
    case Silver = 'silver';
    case Gold = 'gold';
}
