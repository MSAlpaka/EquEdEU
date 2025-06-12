<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Service;

use DateTimeImmutable;

/**
 * Provides the current time, allowing for easier testing.
 */
interface ClockInterface
{
    /**
     * Get the current time as an immutable DateTime instance.
     */
    public function now(): DateTimeImmutable;
}
