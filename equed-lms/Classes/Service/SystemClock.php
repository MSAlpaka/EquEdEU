<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use DateTimeImmutable;
use Equed\EquedLms\Domain\Service\ClockInterface;

/**
 * Default clock using the system time.
 */
final class SystemClock implements ClockInterface
{
    /**
     * {@inheritDoc}
     *
     * @return DateTimeImmutable Current immutable datetime instance
     */
    public function now(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }
}
