<?php

declare(strict_types=1);

namespace Equed\EquedLms\Enum;

/**
 * Status values for training centers.
 */
enum TrainingCenterStatus: string
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Suspended = 'suspended';
}

