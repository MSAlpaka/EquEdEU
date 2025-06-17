<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Service\AppSyncService;
use PHPUnit\Framework\TestCase;

final class AppSyncServiceTest extends TestCase
{
    public function testQueueDataAndFetchPending(): void
    {
        $service = new AppSyncService();
        $service->queueData(1, 'foo', ['a' => 1]);
        $service->queueData(1, 'bar', ['b' => 2]);
        $service->queueData(2, 'baz', []);

        $result = $service->fetchPending(1);
        $this->assertCount(2, $result);
        $this->assertSame('foo', $result[0]['type']);
        $this->assertSame(['a' => 1], $result[0]['payload']);
        $this->assertSame('bar', $result[1]['type']);

        $this->assertSame([], $service->fetchPending(1));

        $other = $service->fetchPending(2);
        $this->assertCount(1, $other);
    }

    public function testFetchPendingReturnsEmptyForUnknownUser(): void
    {
        $service = new AppSyncService();
        $this->assertSame([], $service->fetchPending(99));
    }
}
