<?php

declare(strict_types=1);

namespace Equed\EquedLms\Enum;

/**
 * Status values for feedback entities.
 */
enum FeedbackStatus: string
{
    case Submitted = 'submitted';
    case Reviewed = 'reviewed';
}

