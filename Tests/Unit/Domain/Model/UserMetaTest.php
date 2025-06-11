<?php declare(strict_types=1);

namespace Equed\EquedCore\Tests\Unit\Domain\Model;

use PHPUnit\Framework\TestCase;
use Equed\EquedCore\Domain\Model\UserMeta;

class UserMetaTest extends TestCase
{
    public function testSetGetKey(): void
    {
        $meta = new UserMeta();
        $meta->setKey('test');
        $this->assertSame('test', $meta->getKey());
    }

    public function testDefaultHiddenValue(): void
    {
        $meta = new UserMeta();
        $this->assertFalse($meta->isHidden());
    }
}
