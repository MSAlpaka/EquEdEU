<?php declare(strict_types=1);

namespace Equed\EquedCore\Tests\Unit\Domain\Model;

use PHPUnit\Framework\TestCase;
use Equed\EquedCore\Domain\Model\Country;

class CountryTest extends TestCase
{
    public function testSetGetCountryIso(): void
    {
        $country = new Country();
        $country->setCountryIso('DE');
        $this->assertSame('DE', $country->getCountryIso());
    }

    public function testDefaultHiddenValue(): void
    {
        $country = new Country();
        $this->assertFalse($country->isHidden());
    }
}
