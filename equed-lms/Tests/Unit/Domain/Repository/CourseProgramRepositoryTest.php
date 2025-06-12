<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Domain\Repository;

use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use Equed\EquedLms\Domain\Repository\CourseProgramRepository;
use TYPO3\CMS\Extbase\Persistence\Generic\Query;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use Equed\EquedLms\Domain\Model\CourseProgram;

class CourseProgramRepositoryTest extends TestCase
{
    use ProphecyTrait;

    private CourseProgramRepository $subject;
    private $persistenceManager;
    private $query;

    protected function setUp(): void
    {
        $this->persistenceManager = $this->prophesize(PersistenceManager::class);
        $this->query = $this->prophesize(Query::class);

        $this->persistenceManager
            ->createQueryForType(CourseProgram::class)
            ->willReturn($this->query);

        $this->subject = new CourseProgramRepository();
        $this->subject->injectPersistenceManager($this->persistenceManager->reveal());
    }

    public function testFindVisibleReturnsQueryResult(): void
    {
        $expected = $this->prophesize(QueryResultInterface::class);

        $this->query->matching(\Prophecy\Argument::any())->willReturn($this->query);
        $this->query->execute()->willReturn($expected);
        $expected->toArray()->willReturn([]);

        $result = $this->subject->findVisible();
        $this->assertSame([], $result);
    }

    public function testFindByCategoryReturnsQueryResult(): void
    {
        $expected = $this->prophesize(QueryResultInterface::class);

        $this->query->matching(\Prophecy\Argument::any())->willReturn($this->query);
        $this->query->execute()->willReturn($expected);
        $expected->toArray()->willReturn(['foo']);

        $result = $this->subject->findByCategory('hoofcare');
        $this->assertSame(['foo'], $result);
    }
}
