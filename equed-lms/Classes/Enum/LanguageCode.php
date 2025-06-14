<?php

declare(strict_types=1);

namespace Equed\EquedLms\Enum;

/**
 * Supported language codes for multilingual content.
 */
enum LanguageCode: string
{
    case EN = 'en';
    case DE = 'de';
    case FR = 'fr';
    case ES = 'es';
    case SW = 'sw';
    case EASY = 'easy';
}

