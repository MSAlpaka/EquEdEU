<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Domain\Repository;

use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use Equed\EquedLms\Domain\Repository\LessonRepository;
use TYPO3\CMS\Extbase\Persistence\Generic\Query;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use Equed\EquedLms\Domain\Model\CourseProgram;
use Equed\EquedLms\Domain\Model\Lesson;

class LessonRepositoryTest extends TestCase
{
    use ProphecyTrait;

    private LessonRepository $subject;
    private $query;
    private $persistenceManager;

    protected function setUp(): void
    {
        $this->query = $this->prophesize(Query::class);
        $this->persistenceManager = $this->prophesize(PersistenceManager::class);

        $this->persistenceManager
            ->createQueryForType(Lesson::class)
            ->willReturn($this->query);

        $this->subject = new LessonRepository();
        $this->subject->injectPersistenceManager($this->persistenceManager->reveal());
    }

    public function testFindByCourseInstanceReturnsLessons(): void
    {
        $expected = $this->prophesize(QueryResultInterface::class);

        $this->query->matching(\Prophecy\Argument::any())->willReturn($this->query);
        $this->query->execute()->willReturn($expected);

        $result = $this->subject->findByCourseProgram(new CourseProgram());
        $this->assertSame($expected->reveal(), $result);
    }
}
