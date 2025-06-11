<?php declare(strict_types=1);

namespace Equed\EquedCore\Tests\Unit\Domain\Model;

use PHPUnit\Framework\TestCase;
use Equed\EquedCore\Domain\Model\AuditLog;

class AuditLogTest extends TestCase
{
    public function testSetGetAction(): void
    {
        $log = new AuditLog();
        $log->setAction('login');
        $this->assertSame('login', $log->getAction());
    }

    public function testDefaultHiddenValue(): void
    {
        $log = new AuditLog();
        $this->assertFalse($log->isHidden());
    }
}
