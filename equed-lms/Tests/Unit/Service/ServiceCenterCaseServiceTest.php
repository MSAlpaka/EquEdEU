<?php

declare(strict_types=1);

namespace TYPO3\CMS\Core\Database\Query {
    if (!class_exists(QueryBuilder::class)) {
        class QueryBuilder
        {
            public function select(string $fields): self { return $this; }
            public function from(string $table): self { return $this; }
            public function where($expr): self { return $this; }
            public function orderBy(string $field, string $dir = 'ASC'): self { return $this; }
            public function expr(): object { return new class { public function eq(string $f, $v) { return [$f, $v]; } }; }
            public function executeQuery() { return new \Doctrine\DBAL\Result(); }
        }
    }
}

namespace Doctrine\DBAL {
    if (!class_exists(Result::class)) {
        class Result { public function fetchAllAssociative(): array { return []; } }
    }
}

namespace TYPO3\CMS\Core\Database {
    if (!class_exists(ConnectionPool::class)) {
        class ConnectionPool { public function getQueryBuilderForTable(string $table) { return new \TYPO3\CMS\Core\Database\Query\QueryBuilder(); } }
    }
}

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Service\ServiceCenterCaseService;
use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use Doctrine\DBAL\Result;
use Prophecy\Argument;

final class ServiceCenterCaseServiceTest extends TestCase
{
    use ProphecyTrait;

    public function testGetQmsCasesReturnsRows(): void
    {
        $pool = $this->prophesize(ConnectionPool::class);
        $qb   = $this->prophesize(QueryBuilder::class);
        $res  = $this->prophesize(Result::class);

        $pool->getQueryBuilderForTable('tx_equedlms_domain_model_qms')->willReturn($qb->reveal())->shouldBeCalled();

        $expr = new class { public function eq(string $f, $v) { return [$f, $v]; } };
        $qb->select('*')->willReturn($qb->reveal())->shouldBeCalled();
        $qb->from('tx_equedlms_domain_model_qms')->willReturn($qb->reveal())->shouldBeCalled();
        $qb->expr()->willReturn($expr)->shouldBeCalled();
        $qb->where(Argument::any())->willReturn($qb->reveal())->shouldBeCalled();
        $qb->orderBy('submitted_at', 'DESC')->willReturn($qb->reveal())->shouldBeCalled();
        $qb->executeQuery()->willReturn($res->reveal())->shouldBeCalled();

        $rows = [['uid' => 1]];
        $res->fetchAllAssociative()->willReturn($rows)->shouldBeCalled();

        $service = new ServiceCenterCaseService($pool->reveal());
        $this->assertSame($rows, $service->getQmsCases());
    }

    public function testReturnsEmptyArrayWhenNoRows(): void
    {
        $pool = $this->prophesize(ConnectionPool::class);
        $qb   = $this->prophesize(QueryBuilder::class);
        $res  = $this->prophesize(Result::class);

        $pool->getQueryBuilderForTable('tx_equedlms_domain_model_qms')->willReturn($qb->reveal());
        $qb->select('*')->willReturn($qb->reveal());
        $qb->from('tx_equedlms_domain_model_qms')->willReturn($qb->reveal());
        $qb->expr()->willReturn(new class { public function eq(string $f, $v) { return [$f,$v]; } });
        $qb->where(Argument::any())->willReturn($qb->reveal());
        $qb->orderBy('submitted_at', 'DESC')->willReturn($qb->reveal());
        $qb->executeQuery()->willReturn($res->reveal());
        $res->fetchAllAssociative()->willReturn([]);

        $service = new ServiceCenterCaseService($pool->reveal());
        $this->assertSame([], $service->getQmsCases());
    }
}
