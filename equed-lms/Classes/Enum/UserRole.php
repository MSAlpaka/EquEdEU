<?php

declare(strict_types=1);

namespace Equed\EquedLms\Enum;

/**
 * Available frontend user roles.
 */
enum UserRole: string
{
    case Learner = 'learner';
    case Instructor = 'instructor';
    case Certifier = 'certifier';
    case ServiceCenter = 'sc_user';
}
