<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Domain\Model;

use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Domain\Model\LessonProgress;

class LessonProgressTest extends TestCase
{
    public function testConstructorInitializesFields(): void
    {
        $progress = new LessonProgress();
        $this->assertNotEmpty($progress->getUuid());
        $this->assertInstanceOf(\DateTimeImmutable::class, $progress->getCreatedAt());
        $this->assertInstanceOf(\DateTimeImmutable::class, $progress->getUpdatedAt());
    }

    public function testProgressAccessors(): void
    {
        $progress = new LessonProgress();
        $progress->setProgress(42);
        $this->assertSame(42, $progress->getProgress());
    }
}
