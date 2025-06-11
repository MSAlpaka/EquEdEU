<?php

declare(strict_types=1);

namespace Equed\EquedLms\Enum;

/**
 * Possible certificate design types.
 */
enum CertificateDesignType: string
{
    case Classic = 'classic';
    case Modern = 'modern';
}
