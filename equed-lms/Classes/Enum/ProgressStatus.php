<?php

declare(strict_types=1);

namespace Equed\EquedLms\Enum;

/**
 * Basic progress states for lessons or courses.
 */
enum ProgressStatus: string
{
    case NotStarted = 'notStarted';
    case InProgress = 'inProgress';
    case Completed  = 'completed';
}
