<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Domain\Enum;

use Equed\EquedLms\Enum\CourseStatus;
use PHPUnit\Framework\TestCase;

final class CourseStatusTest extends TestCase
{
    public function testToLabel(): void
    {
        $this->assertSame('Entwurf', CourseStatus::Draft->toLabel());
        $this->assertSame('Veröffentlicht', CourseStatus::Published->toLabel());
        $this->assertSame('Archiviert', CourseStatus::Archived->toLabel());
        $this->assertSame('Abgesagt', CourseStatus::Canceled->toLabel());
        $this->assertSame('Geschlossen', CourseStatus::Closed->toLabel());
        $this->assertSame('Versteckt', CourseStatus::Hidden->toLabel());
    }

    public function testIsVisible(): void
    {
        $this->assertFalse(CourseStatus::Draft->isVisible());
        $this->assertTrue(CourseStatus::Published->isVisible());
        $this->assertTrue(CourseStatus::Archived->isVisible());
        $this->assertFalse(CourseStatus::Canceled->isVisible());
        $this->assertTrue(CourseStatus::Closed->isVisible());
        $this->assertFalse(CourseStatus::Hidden->isVisible());
    }

    public function testIsBookable(): void
    {
        $this->assertTrue(CourseStatus::Published->isBookable());

        $nonBookableStatuses = [
            CourseStatus::Draft,
            CourseStatus::Archived,
            CourseStatus::Canceled,
            CourseStatus::Closed,
            CourseStatus::Hidden,
        ];

        foreach ($nonBookableStatuses as $status) {
            $this->assertFalse($status->isBookable(), sprintf('%s should not be bookable', $status->name));
        }
    }
}
