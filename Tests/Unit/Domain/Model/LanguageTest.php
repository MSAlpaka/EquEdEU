<?php declare(strict_types=1);

namespace Equed\EquedCore\Tests\Unit\Domain\Model;

use PHPUnit\Framework\TestCase;
use Equed\EquedCore\Domain\Model\Language;

class LanguageTest extends TestCase
{
    public function testSetGetLanguageIso(): void
    {
        $language = new Language();
        $language->setLanguageIso('de-DE');
        $this->assertSame('de-DE', $language->getLanguageIso());
    }

    public function testDefaultHiddenValue(): void
    {
        $language = new Language();
        $this->assertFalse($language->isHidden());
    }
}
