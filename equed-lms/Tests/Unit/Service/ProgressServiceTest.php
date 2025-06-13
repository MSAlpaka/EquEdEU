<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use DateTimeImmutable;
use Equed\EquedLms\Service\ProgressService;
use Equed\EquedLms\Domain\Repository\UserCourseRecordRepositoryInterface;
use Equed\EquedLms\Domain\Service\LanguageServiceInterface;
use Equed\EquedLms\Domain\Service\ClockInterface;
use Equed\EquedLms\Domain\Model\UserCourseRecord;
use Equed\EquedLms\Domain\Model\CourseInstance;
use Equed\EquedLms\Domain\Model\CourseProgram;
use Equed\EquedLms\Enum\UserCourseStatus;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;

final class ProgressServiceTest extends TestCase
{
    use ProphecyTrait;

    private ProgressService $subject;
    private $repo;
    private $language;
    private $pool;
    private $clock;

    protected function setUp(): void
    {
        $this->repo = $this->prophesize(UserCourseRecordRepositoryInterface::class);
        $this->language = $this->prophesize(LanguageServiceInterface::class);
        $this->pool = $this->prophesize(ConnectionPool::class);
        $this->clock = $this->prophesize(ClockInterface::class);

        $this->subject = new ProgressService(
            $this->repo->reveal(),
            $this->language->reveal(),
            $this->pool->reveal(),
            $this->clock->reveal(),
        );
    }

    public function testGetProgressDataForUserReturnsAggregatedProgress(): void
    {
        $program1 = new CourseProgram();
        $program1->_setProperty('uid', 1);
        $instance1 = new CourseInstance();
        $instance1->setTitle('First');
        $instance1->setCourseProgram($program1);
        $record1 = new UserCourseRecord();
        $record1->setCourseInstance($instance1);
        $record1->setProgressPercent(30.0);
        $record1->setStatus(UserCourseStatus::InProgress);

        $program2 = new CourseProgram();
        $program2->_setProperty('uid', 2);
        $instance2 = new CourseInstance();
        $instance2->setTitle('Second');
        $instance2->setCourseProgram($program2);
        $record2 = new UserCourseRecord();
        $record2->setCourseInstance($instance2);
        $record2->setProgressPercent(70.0);
        $record2->setStatus(UserCourseStatus::Validated);

        $this->repo->findByUserId(5)->willReturn([$record1, $record2]);
        $this->language->translate('status.notStarted')->willReturn('n/a')->shouldBeCalledTimes(2);

        $result = $this->subject->getProgressDataForUser(5);

        $this->assertSame(50, $result['overallPercent']);
        $this->assertCount(2, $result['courses']);
        $this->assertSame(1, $result['courses'][0]['courseId']);
        $this->assertSame('First', $result['courses'][0]['courseTitle']);
        $this->assertSame(30, $result['courses'][0]['progress']);
        $this->assertSame('n/a', $result['courses'][0]['status']);
    }

    public function testCleanupAbandonedCourseProgressExecutesQuery(): void
    {
        $qb = $this->prophesize(QueryBuilder::class);
        $expr = new class {
            public function lt(string $field, $value) { return ['lt',$field,$value]; }
            public function eq(string $field, $value) { return ['eq',$field,$value]; }
        };

        $connection = $this->prophesize(Connection::class);
        $this->pool->getConnectionForTable('tx_equedlms_domain_model_usercourserecord')
            ->willReturn($connection->reveal());
        $connection->createQueryBuilder()->willReturn($qb->reveal());

        $qb->expr()->willReturn($expr);
        $qb->delete('tx_equedlms_domain_model_usercourserecord')->willReturn($qb->reveal())->shouldBeCalled();
        $cutoff = '2024-05-21 00:00:00';
        $this->clock->now()->willReturn(new DateTimeImmutable('2024-06-01 00:00:00'));
        $qb->createNamedParameter($cutoff)->willReturn($cutoff)->shouldBeCalled();
        $qb->createNamedParameter(UserCourseStatus::InProgress->value)
            ->willReturn(UserCourseStatus::InProgress->value)
            ->shouldBeCalled();
        $qb->where(['lt','last_activity',$cutoff], ['eq','status',UserCourseStatus::InProgress->value])
            ->willReturn($qb->reveal())
            ->shouldBeCalled();
        $qb->executeStatement()->shouldBeCalled();

        $this->subject->cleanupAbandonedCourseProgress(11);
    }
}

