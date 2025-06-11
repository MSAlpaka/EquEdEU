<?php

declare(strict_types=1);

namespace Equed\Core\Service {
    interface UuidGeneratorInterface { public function generate(): string; }
    interface ClockInterface { public function now(): \DateTimeImmutable; }
}

namespace Equed\EquedLms\Tests\Unit\Domain\Model {

    use DateTimeImmutable;
    use PHPUnit\Framework\TestCase;
    use ReflectionClass;
    use ReflectionProperty;
    use Equed\EquedLms\Domain\Model\CourseAccessMap;
    use Equed\Core\Service\UuidGeneratorInterface;
    use Equed\Core\Service\ClockInterface;

    class FakeClock implements ClockInterface
    {
        public function __construct(private DateTimeImmutable $now) {}
        public function now(): DateTimeImmutable { return $this->now; }
    }

    class FakeUuidGenerator implements UuidGeneratorInterface
    {
        public function __construct(private string $uuid) {}
        public function generate(): string { return $this->uuid; }
    }

    class CourseAccessMapInitializationTest extends TestCase
    {
        public function testInitializeObjectSetsUuidAndTimestamps(): void
        {
            $fixed = new DateTimeImmutable('2024-06-01 12:00:00');
            $clock = new FakeClock($fixed);
            $uuidGen = new FakeUuidGenerator('abcdefab-1234-5678-9abc-def012345678');

            $ref = new ReflectionClass(CourseAccessMap::class);
            $subject = $ref->newInstanceWithoutConstructor();

            $prop = new ReflectionProperty($subject, 'clock');
            $prop->setAccessible(true);
            $prop->setValue($subject, $clock);

            $prop = new ReflectionProperty($subject, 'uuidGenerator');
            $prop->setAccessible(true);
            $prop->setValue($subject, $uuidGen);

            $prop = new ReflectionProperty($subject, 'uuid');
            $prop->setAccessible(true);
            $prop->setValue($subject, '');

            $subject->initializeObject();

            $this->assertSame('abcdefab-1234-5678-9abc-def012345678', $subject->getUuid());
            $this->assertEquals($fixed, $subject->getCreatedAt());
            $this->assertEquals($fixed, $subject->getUpdatedAt());
        }
    }
}
