<?php

declare(strict_types=1);

namespace Equed\EquedLms\Enum;

/**
 * Defines how course validations are handled.
 */
enum ValidationMode: string
{
    case Instructor = 'instructor';
    case Certifier = 'certifier';
    case ServiceCenter = 'servicecenter';
}
