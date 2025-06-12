<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Domain\Repository;

use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use Equed\EquedLms\Domain\Repository\ModuleRepository;
use TYPO3\CMS\Extbase\Persistence\Generic\Query;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use Equed\EquedLms\Domain\Model\CourseProgram;
use Equed\EquedLms\Domain\Model\Module;

class ModuleRepositoryTest extends TestCase
{
    use ProphecyTrait;

    private ModuleRepository $subject;
    private $persistenceManager;
    private $query;

    protected function setUp(): void
    {
        $this->persistenceManager = $this->prophesize(PersistenceManager::class);
        $this->query = $this->prophesize(Query::class);

        $this->persistenceManager
            ->createQueryForType(Module::class)
            ->willReturn($this->query);

        $this->subject = new ModuleRepository();
        $this->subject->injectPersistenceManager($this->persistenceManager->reveal());
    }

    public function testFindByCourseProgramReturnsModules(): void
    {
        $expected = $this->prophesize(QueryResultInterface::class);

        $this->query->matching(\Prophecy\Argument::any())->willReturn($this->query);
        $this->query->execute()->willReturn($expected);
        $expected->toArray()->willReturn(['mod']);

        $result = $this->subject->findByCourseProgram(new CourseProgram());
        $this->assertSame(['mod'], $result);
    }

    public function testFindByIdentifierReturnsModule(): void
    {
        $expectedResult = $this->prophesize(QueryResultInterface::class);
        $module = new Module();

        $this->query->matching(\Prophecy\Argument::any())->willReturn($this->query);
        $this->query->setLimit(1)->willReturn($this->query);
        $this->query->execute()->willReturn($expectedResult);
        $expectedResult->getFirst()->willReturn($module);

        $result = $this->subject->findByIdentifier('mod-1');
        $this->assertSame($module, $result);
    }

    public function testFindActiveModulesReturnsModules(): void
    {
        $expected = $this->prophesize(QueryResultInterface::class);

        $this->query->matching(\Prophecy\Argument::any())->willReturn($this->query);
        $this->query->execute()->willReturn($expected);
        $expected->toArray()->willReturn(['mod']);

        $result = $this->subject->findActiveModules(new CourseProgram());
        $this->assertSame(['mod'], $result);
    }
}
