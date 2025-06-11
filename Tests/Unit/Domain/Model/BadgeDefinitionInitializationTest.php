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
    use Equed\EquedLms\Domain\Model\BadgeDefinition;
    use Equed\EquedLms\Enum\BadgeLevel;
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

    class BadgeDefinitionInitializationTest extends TestCase
    {
        public function testInitializeObjectSetsUuidAndTimestamps(): void
        {
            $fixed = new DateTimeImmutable('2024-05-01 00:00:00');
            $clock = new FakeClock($fixed);
            $uuidGen = new FakeUuidGenerator('12345678-1234-1234-1234-123456789abc');

            $ref = new ReflectionClass(BadgeDefinition::class);
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

            $this->assertSame('12345678-1234-1234-1234-123456789abc', $subject->getUuid());
            $this->assertEquals($fixed, $subject->getCreatedAt());
            $this->assertEquals($fixed, $subject->getUpdatedAt());
        }
    }
}
