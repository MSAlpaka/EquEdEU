<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Service\SystemClock;
use PHPUnit\Framework\TestCase;

final class SystemClockTest extends TestCase
{
    public function testNowReturnsCurrentTime(): void
    {
        $clock = new SystemClock();
        $before = time();
        $now = $clock->now();
        $this->assertGreaterThanOrEqual($before, $now->getTimestamp());
        $this->assertLessThanOrEqual(time(), $now->getTimestamp());
    }
}
