<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Service\RandomTokenGenerator;
use PHPUnit\Framework\TestCase;

final class RandomTokenGeneratorTest extends TestCase
{
    public function testGenerateReturnsCorrectLength(): void
    {
        $gen = new RandomTokenGenerator();
        $token = $gen->generate(8);
        $this->assertSame(8, strlen($token));
    }

    public function testGenerateZeroLengthThrowsException(): void
    {
        $gen = new RandomTokenGenerator();
        $this->expectException(\ValueError::class);
        $gen->generate(0);
    }
}
