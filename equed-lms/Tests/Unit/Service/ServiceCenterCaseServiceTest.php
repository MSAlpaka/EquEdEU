<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Service\ServiceCenterCaseService;
use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use Equed\EquedLms\Domain\Repository\QmsCaseRecordRepositoryInterface;

final class ServiceCenterCaseServiceTest extends TestCase
{
    use ProphecyTrait;

    public function testGetQmsCasesDelegatesToRepository(): void
    {
        $repo = $this->prophesize(QmsCaseRecordRepositoryInterface::class);
        $rows = [['uid' => 1]];
        $repo->findAll()->willReturn($rows)->shouldBeCalled();

        $service = new ServiceCenterCaseService($repo->reveal());
        $this->assertSame($rows, $service->getQmsCases());
    }

    public function testReturnsEmptyArrayWhenNoRows(): void
    {
        $repo = $this->prophesize(QmsCaseRecordRepositoryInterface::class);
        $repo->findAll()->willReturn([])->shouldBeCalled();

        $service = new ServiceCenterCaseService($repo->reveal());
        $this->assertSame([], $service->getQmsCases());
    }
}
