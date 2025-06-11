<?php declare(strict_types=1);

namespace Equed\EquedCore\Tests\Unit\Domain\Model;

use PHPUnit\Framework\TestCase;
use Equed\EquedCore\Domain\Model\SearchLog;

class SearchLogTest extends TestCase
{
    public function testSetGetSearchTerm(): void
    {
        $log = new SearchLog();
        $log->setSearchTerm('query');
        $this->assertSame('query', $log->getSearchTerm());
    }

    public function testDefaultHiddenValue(): void
    {
        $log = new SearchLog();
        $this->assertFalse($log->isHidden());
    }
}
