<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Domain\Repository;

use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use Equed\EquedLms\Domain\Repository\CourseBundleRepository;
use TYPO3\CMS\Extbase\Persistence\Generic\Query;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Equed\EquedLms\Domain\Model\CourseBundle;

class CourseBundleRepositoryTest extends TestCase
{
    use ProphecyTrait;

    private CourseBundleRepository $subject;
    private $persistenceManager;
    private $query;

    protected function setUp(): void
    {
        $this->persistenceManager = $this->prophesize(PersistenceManager::class);
        $this->query = $this->prophesize(Query::class);

        $this->persistenceManager
            ->createQueryForType(CourseBundle::class)
            ->willReturn($this->query);

        $this->subject = new CourseBundleRepository();
        $this->subject->injectPersistenceManager($this->persistenceManager->reveal());
    }

    public function testFindByBundleKeyReturnsResults(): void
    {
        $expected = $this->prophesize(QueryResultInterface::class);
        $this->query->matching(\Prophecy\Argument::any())->willReturn($this->query);
        $this->query->execute()->willReturn($expected);

        $result = $this->subject->findByBundleKey('HC-BASIC');
        $this->assertSame($expected->reveal(), $result);
    }
}
