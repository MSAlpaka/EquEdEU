<?php

declare(strict_types=1);

namespace TYPO3\CMS\Core\Database;
if (!class_exists(ConnectionPool::class)) {
    class ConnectionPool {
        public function getQueryBuilderForTable(string $table) { return null; }
    }
}

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Service\SearchService;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Database\ConnectionPool;

final class SearchServiceTest extends TestCase
{
    public function testReturnsErrorForTooShortTerm(): void
    {
        $service = new SearchService(new ConnectionPool());
        $result = $service->search('a');
        $this->assertTrue($result->hasError());
        $this->assertSame('Search term too short.', $result->getError());
    }
}
