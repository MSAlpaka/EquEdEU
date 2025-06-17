<?php
declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Service\Dashboard\CacheManager;
use Equed\EquedLms\Dto\DashboardData;
use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use Prophecy\Argument;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;

class CacheManagerTest extends TestCase
{
    use ProphecyTrait;

    public function testFetchReturnsNullWhenCacheMiss(): void
    {
        $pool = $this->prophesize(CacheItemPoolInterface::class);
        $item = $this->prophesize(CacheItemInterface::class);
        $item->isHit()->willReturn(false);
        $pool->getItem('dashboard_user_5')->willReturn($item->reveal());

        $manager = new CacheManager($pool->reveal());

        $this->assertNull($manager->fetch(5));
    }

    public function testSaveStoresItemWithTtl(): void
    {
        $pool = $this->prophesize(CacheItemPoolInterface::class);
        $item = $this->prophesize(CacheItemInterface::class);
        $data = new DashboardData([], [], [], [], [], [], []);

        $ttl = 123;
        $pool->getItem('dashboard_user_7')->willReturn($item->reveal());
        $item->set($data)->willReturn($item->reveal())->shouldBeCalled();
        $item->expiresAfter($ttl)->willReturn($item->reveal())->shouldBeCalled();
        $pool->save($item->reveal())->shouldBeCalled();

        $manager = new CacheManager($pool->reveal(), $ttl);
        $manager->save(7, $data);
    }
}
