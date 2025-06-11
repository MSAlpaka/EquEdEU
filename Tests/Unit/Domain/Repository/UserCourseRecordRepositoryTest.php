<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Domain\Repository;

use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use Equed\EquedLms\Domain\Repository\UserCourseRecordRepository;
use TYPO3\CMS\Extbase\Persistence\Generic\Query;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Domain\Model\UserCourseRecord;

class UserCourseRecordRepositoryTest extends TestCase
{
    use ProphecyTrait;

    private UserCourseRecordRepository $subject;
    private $query;
    private $persistenceManager;

    protected function setUp(): void
    {
        $this->query = $this->prophesize(Query::class);
        $this->persistenceManager = $this->prophesize(PersistenceManager::class);

        $this->persistenceManager
            ->createQueryForType(UserCourseRecord::class)
            ->willReturn($this->query);

        $this->subject = new UserCourseRecordRepository();
        $this->subject->injectPersistenceManager($this->persistenceManager->reveal());
    }

    public function testFindByUserReturnsQueryResult(): void
    {
        $expected = $this->prophesize(QueryResultInterface::class);

        $this->query->matching(\Prophecy\Argument::any())->willReturn($this->query);
        $this->query->execute()->willReturn($expected);

        $result = $this->subject->findByUser(new FrontendUser());
        $this->assertSame($expected->reveal(), $result);
    }
}
