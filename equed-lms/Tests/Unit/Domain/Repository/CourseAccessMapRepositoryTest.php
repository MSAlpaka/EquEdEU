<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Domain\Repository;

use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use Equed\EquedLms\Domain\Repository\CourseAccessMapRepository;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Persistence\Generic\Query;
use Equed\EquedLms\Domain\Model\CourseAccessMap;
use Equed\EquedLms\Domain\Model\CourseProgram;
use Equed\EquedLms\Domain\Model\FrontendUser;

class CourseAccessMapRepositoryTest extends TestCase
{
    use ProphecyTrait;

    private CourseAccessMapRepository $subject;
    private $persistenceManager;
    private $query;

    protected function setUp(): void
    {
        $this->persistenceManager = $this->prophesize(PersistenceManager::class);
        $this->query = $this->prophesize(Query::class);

        $this->persistenceManager
            ->createQueryForType(CourseAccessMap::class)
            ->willReturn($this->query);

        $this->subject = new CourseAccessMapRepository();
        $this->subject->injectPersistenceManager($this->persistenceManager->reveal());
    }

    public function testFindByUserExecutesQuery(): void
    {
        $result = $this->prophesize(QueryResultInterface::class);
        $this->query->matching(\Prophecy\Argument::any())->willReturn($this->query);
        $this->query->execute()->willReturn($result);

        $records = $this->subject->findByUser(new FrontendUser());
        $this->assertSame($result->reveal(), $records);
    }
}
