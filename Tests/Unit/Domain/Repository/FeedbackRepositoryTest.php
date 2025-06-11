<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Domain\Repository;

use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use Equed\EquedLms\Domain\Repository\FeedbackRepository;
use TYPO3\CMS\Extbase\Persistence\Generic\Query;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

class FeedbackRepositoryTest extends TestCase
{
    use ProphecyTrait;

    private FeedbackRepository $subject;
    private $query;
    private $persistenceManager;

    protected function setUp(): void
    {
        $this->query = $this->prophesize(Query::class);
        $this->persistenceManager = $this->prophesize(PersistenceManager::class);

        $this->persistenceManager
            ->createQueryForType(\Equed\EquedLms\Domain\Model\Feedback::class)
            ->willReturn($this->query);

        $this->subject = new FeedbackRepository();
        $this->subject->injectPersistenceManager($this->persistenceManager->reveal());
    }

    public function testFindUnanalyzedReturnsExpectedResults(): void
    {
        $expected = $this->prophesize(QueryResultInterface::class);

        $this->query->matching(\Prophecy\Argument::any())->willReturn($this->query);
        $this->query->execute()->willReturn($expected);

        $result = $this->subject->findUnanalyzed();
        $this->assertSame($expected->reveal(), $result);
    }
}
