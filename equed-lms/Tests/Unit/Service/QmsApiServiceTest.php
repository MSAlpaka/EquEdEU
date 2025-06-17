<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Service\QmsApiService;
use Equed\EquedLms\Domain\Repository\QmsCaseRecordRepositoryInterface;
use Equed\EquedLms\Domain\Service\ClockInterface;
use Equed\EquedLms\Dto\QmsCloseRequest;
use Equed\EquedLms\Dto\QmsRespondRequest;
use Equed\EquedLms\Dto\QmsSubmitRequest;
use Equed\EquedLms\Dto\QmsCaseData;
use PHPUnit\Framework\TestCase;
use DateTimeImmutable;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;

final class QmsApiServiceTest extends TestCase
{
    use ProphecyTrait;

    private QmsApiService $subject;
    private $repo;
    private $clock;

    protected function setUp(): void
    {
        $this->repo = $this->prophesize(QmsCaseRecordRepositoryInterface::class);
        $this->clock = $this->prophesize(ClockInterface::class);
        $this->subject = new QmsApiService($this->repo->reveal(), $this->clock->reveal());
    }

    public function testGetCasesForUserDelegatesToRepository(): void
    {
        $this->repo->findByUserId(5)->willReturn([
            [
                'uid'            => 1,
                'usercourserecord' => 2,
                'type'           => 'general',
                'message'        => 'm',
                'status'         => 'open',
                'submitted_at'   => 100,
                'responded_at'   => null,
                'closed_at'      => null,
            ],
        ])->shouldBeCalled();

        $cases = $this->subject->getCasesForUser(5);

        $this->assertCount(1, $cases);
        $this->assertInstanceOf(QmsCaseData::class, $cases[0]);
        $this->assertSame(1, $cases[0]->getId());
    }

    public function testSubmitCaseUsesRepository(): void
    {
        $dto = new QmsSubmitRequest(1, 2, 'msg');
        $this->clock->now()->willReturn(new DateTimeImmutable('2024-06-01'));
        $this->repo->addCase(1, 2, 'general', 'msg', 1717200000)->shouldBeCalled();

        $this->subject->submitCase($dto);
    }

    public function testRespondToCaseUsesRepository(): void
    {
        $dto = new QmsRespondRequest(3, 4, 'ok', 'trainer');
        $this->clock->now()->willReturn(new DateTimeImmutable('2024-06-01'));
        $this->repo->respondToCase(4, 3, 'trainer', 'ok', 1717200000)->shouldBeCalled();

        $this->subject->respondToCase($dto);
    }

    public function testCloseCaseUsesRepository(): void
    {
        $dto = new QmsCloseRequest(9, 7);
        $this->clock->now()->willReturn(new DateTimeImmutable('2024-06-01'));
        $this->repo->closeCase(7, 9, 1717200000)->shouldBeCalled();

        $this->subject->closeCase($dto);
    }
}
