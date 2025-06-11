<?php

declare(strict_types=1);

namespace Equed\Core\Service {
    interface ClockInterface
    {
        public function now(): \DateTimeImmutable;
    }
}

namespace TYPO3\CMS\Extbase\Domain\Model {
    if (!class_exists(FrontendUser::class)) {
        class FrontendUser
        {
        }
    }
}

namespace Equed\EquedLms\Tests\Unit\Domain\Model {

    use DateTimeImmutable;
    use PHPUnit\Framework\TestCase;
    use Equed\EquedLms\Domain\Model\CourseBookingRequest;
    use Equed\EquedLms\Domain\Model\CourseProgram;
    use Equed\EquedLms\Domain\Model\FrontendUser;
    use Equed\Core\Service\ClockInterface;
    use ReflectionProperty;

    class FakeClock implements ClockInterface
    {
        public function __construct(private DateTimeImmutable $now)
        {
        }
        public function now(): DateTimeImmutable
        {
            return $this->now;
        }
    }

    class CourseBookingRequestTimestampTest extends TestCase
    {
        public function testInitializeObjectUsesInjectedClock(): void
        {
            $fixed = new DateTimeImmutable('2024-05-01 12:00:00');
            $clock = new FakeClock($fixed);
            $subject = new CourseBookingRequest();

            $prop = new ReflectionProperty($subject, 'clock');
            $prop->setAccessible(true);
            $prop->setValue($subject, $clock);

            $subject->initializeObject();

            $this->assertEquals($fixed, $subject->getCreatedAt());
            $this->assertEquals($fixed, $subject->getUpdatedAt());
        }

        public function testFieldAccessors(): void
        {
            $subject = new CourseBookingRequest();
            $user = new FrontendUser();
            $program = new CourseProgram();
            $date = new DateTimeImmutable('2024-05-10 15:00:00');

            $subject->setFeUser($user);
            $subject->setCourseProgram($program);
            $subject->setPreferredRegion('EU');
            $subject->setNote('note');
            $subject->setRequestedAt($date);

            $this->assertSame($user, $subject->getFeUser());
            $this->assertSame($program, $subject->getCourseProgram());
            $this->assertSame('EU', $subject->getPreferredRegion());
            $this->assertSame('note', $subject->getNote());
            $this->assertSame($date, $subject->getRequestedAt());
        }
    }
}
