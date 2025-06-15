<?php

declare(strict_types=1);

namespace Equed\EquedLms\Enum;

/**
 * Allowed types for notifications.
 */
enum NotificationType: string
{
    case Info = 'info';
    case Success = 'success';
    case Warning = 'warning';
    case Alert = 'alert';
    case Certificate = 'certificate';
    case Submission = 'submission';
    case System = 'system';
}

