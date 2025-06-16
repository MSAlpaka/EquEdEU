<?php

declare(strict_types=1);

namespace Equed\EquedLms\Enum;

/**
 * Possible status values for user profiles.
 */
enum UserProfileStatus: string
{
    case Active = 'active';
    case Paused = 'paused';
    case Review = 'review';
}

