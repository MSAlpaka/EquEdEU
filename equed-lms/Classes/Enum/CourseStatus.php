<?php

declare(strict_types=1);

namespace Equed\EquedLms\Enum;

/**
 * Enum CourseStatus
 *
 * Indicates the current status of a course.
 */
enum CourseStatus: string
{
    case Draft = 'draft';             // still in progress, not visible
    case Published = 'published';     // visible and bookable
    case Archived = 'archived';       // completed, visible in the archive
    case Canceled = 'canceled';       // cancelled, visible with a note
    case Closed = 'closed';           // execution finished, no more registration
    case Hidden = 'hidden';           // published but hidden in the frontend

    /**
     * Returns the label shown to users for this status.
     */
    public function toLabel(): string
    {
        return match($this) {
            self::Draft => 'Entwurf',
            self::Published => 'Veröffentlicht',
            self::Archived => 'Archiviert',
            self::Canceled => 'Abgesagt',
            self::Closed => 'Geschlossen',
            self::Hidden => 'Versteckt',
        };
    }

    /**
     * Checks if a course with this status should be visible in the frontend.
     */
    public function isVisible(): bool
    {
        return match($this) {
            self::Published, self::Archived, self::Closed => true,
            self::Draft, self::Canceled, self::Hidden => false,
        };
    }

    /**
     * Checks if a booking is currently possible.
     */
    public function isBookable(): bool
    {
        return $this === self::Published;
    }
}
