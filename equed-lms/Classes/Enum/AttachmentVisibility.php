<?php

declare(strict_types=1);

namespace Equed\EquedLms\Enum;

/**
 * Visibility options for submission attachments.
 */
enum AttachmentVisibility: string
{
    case InstructorOnly = 'instructor_only';
}
