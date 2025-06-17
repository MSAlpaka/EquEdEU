<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Service\ServiceCenterCaseService;
use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use Equed\EquedLms\Domain\Repository\QmsCaseRecordRepositoryInterface;
use Equed\EquedLms\Dto\QmsCaseDto;

final class ServiceCenterCaseServiceTest extends TestCase
{
    use ProphecyTrait;

    public function testGetQmsCasesDelegatesToRepository(): void
    {
        $repo = $this->prophesize(QmsCaseRecordRepositoryInterface::class);
        $rows = [[
            'uid'            => 1,
            'usercourserecord' => 2,
            'type'           => 'general',
            'message'        => 'm',
            'status'         => 'open',
            'submitted_at'   => 100,
            'responded_at'   => null,
            'closed_at'      => null,
        ]];
        $repo->findAll()->willReturn($rows)->shouldBeCalled();

        $service = new ServiceCenterCaseService($repo->reveal());
        $cases = $service->getQmsCases();
        $this->assertCount(1, $cases);
        $this->assertInstanceOf(QmsCaseDto::class, $cases[0]);
        $this->assertSame(1, $cases[0]->getId());
    }

    public function testReturnsEmptyArrayWhenNoRows(): void
    {
        $repo = $this->prophesize(QmsCaseRecordRepositoryInterface::class);
        $repo->findAll()->willReturn([])->shouldBeCalled();

        $service = new ServiceCenterCaseService($repo->reveal());
        $this->assertSame([], $service->getQmsCases());
    }
}
