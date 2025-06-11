<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Domain\Model;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Domain\Model\CourseProgram;

class CourseProgramTest extends TestCase
{
    private CourseProgram $subject;

    protected function setUp(): void
    {
        $this->subject = new CourseProgram();
    }

    public function testSetAndGetTitle(): void
    {
        $this->subject->setTitle('HoofCare Basic');
        $this->assertSame('HoofCare Basic', $this->subject->getTitle());
    }

    public function testSetAndGetDescription(): void
    {
        $desc = 'Foundation-level course in barefoot trimming.';
        $this->subject->setDescription($desc);
        $this->assertSame($desc, $this->subject->getDescription());
    }

    public function testSetAndGetCategory(): void
    {
        $this->subject->setCategory('hoofcare');
        $this->assertSame('hoofcare', $this->subject->getCategory());
    }

    public function testSetAndGetAvailableFrom(): void
    {
        $date = new DateTimeImmutable('2024-06-01');
        $this->subject->setAvailableFrom($date);
        $this->assertSame($date, $this->subject->getAvailableFrom());
    }

    public function testVisibilityFlags(): void
    {
        $this->subject->setVisible(false);
        $this->subject->setArchived(true);

        $this->assertFalse($this->subject->isVisible());
        $this->assertTrue($this->subject->isArchived());
    }
}
