<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model {
    class QmsCase {
        private bool $escalated = false;
        public function setEscalated(bool $flag): void { $this->escalated = $flag; }
        public function isEscalated(): bool { return $this->escalated; }
    }
}

namespace Equed\EquedLms\Domain\Repository {
    interface QmsCaseRepositoryInterface {
        public function findOpenCases(): array;
        public function findByInstructor(int $id): array;
        public function findByUid(int $id): ?\Equed\EquedLms\Domain\Model\QmsCase;
        public function update(\Equed\EquedLms\Domain\Model\QmsCase $case): void;
    }
}

namespace TYPO3\CMS\Extbase\Persistence {
    if (!interface_exists(PersistenceManagerInterface::class)) {
        interface PersistenceManagerInterface { public function persistAll(); }
    }
}

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Service\QmsService;
use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use Equed\EquedLms\Domain\Repository\QmsCaseRepositoryInterface;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use Equed\EquedLms\Domain\Model\QmsCase;

final class QmsServiceTest extends TestCase
{
    use ProphecyTrait;

    private QmsService $subject;
    private $repo;
    private $pm;

    protected function setUp(): void
    {
        $this->repo = $this->prophesize(QmsCaseRepositoryInterface::class);
        $this->pm = $this->prophesize(PersistenceManagerInterface::class);
        $this->subject = new QmsService($this->repo->reveal(), $this->pm->reveal());
    }

    public function testGetOpenCasesDelegatesToRepository(): void
    {
        $cases = [new QmsCase()];
        $this->repo->findOpenCases()->willReturn($cases);
        $this->assertSame($cases, $this->subject->getOpenCases());
    }

    public function testGetCasesByInstructorDelegatesToRepository(): void
    {
        $cases = [new QmsCase()];
        $this->repo->findByInstructor(5)->willReturn($cases);
        $this->assertSame($cases, $this->subject->getCasesByInstructor(5));
    }

    public function testEscalateCaseUpdatesRecord(): void
    {
        $case = new QmsCase();
        $this->repo->findByUid(2)->willReturn($case);
        $this->repo->update($case)->shouldBeCalled();
        $this->pm->persistAll()->shouldBeCalled();

        $result = $this->subject->escalateCase(2);
        $this->assertTrue($result);
        $this->assertTrue($case->isEscalated());
    }

    public function testEscalateCaseReturnsFalseWhenNotFound(): void
    {
        $this->repo->findByUid(9)->willReturn(null);
        $this->pm->persistAll()->shouldNotBeCalled();
        $this->repo->update(\Prophecy\Argument::any())->shouldNotBeCalled();

        $this->assertFalse($this->subject->escalateCase(9));
    }
}
