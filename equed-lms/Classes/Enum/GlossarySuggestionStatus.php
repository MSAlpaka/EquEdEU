<?php

declare(strict_types=1);

namespace Equed\EquedLms\Enum;

/**
 * Status values for glossary suggestions.
 */
enum GlossarySuggestionStatus: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';
}

