<?php

declare(strict_types=1);

namespace Ramsey\Uuid;

if (!class_exists(Uuid::class)) {
    class Uuid
    {
        public static function uuid4()
        {
            return new class {
                public function toString()
                {
                    return 'generated';
                }
            };
        }
    }
}

namespace Equed\Core\Service;

interface UuidGeneratorInterface { public function generate(): string; }
interface ClockInterface { public function now(): \DateTimeImmutable; }

namespace TYPO3\CMS\Extbase\Domain\Model;

if (!class_exists(FrontendUser::class)) {
    class FrontendUser
    {
        private array $properties = [];

        public function _setProperty(string $name, mixed $value): void
        {
            $this->properties[$name] = $value;
        }

        public function _getProperty(string $name): mixed
        {
            return $this->properties[$name] ?? null;
        }
    }
}

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Domain\Model\UserProfile;
use Equed\EquedLms\Domain\Repository\UserProfileRepositoryInterface;
use Equed\EquedLms\Service\SyncService;
use Equed\Core\Service\ClockInterface;
use Equed\EquedLms\Domain\Service\ClockInterface as DomainClockInterface;
use Equed\Core\Service\UuidGeneratorInterface;
use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use Prophecy\Argument;

class FakeClock implements ClockInterface, DomainClockInterface
{
    public function __construct(private \DateTimeImmutable $now) {}
    public function now(): \DateTimeImmutable { return $this->now; }
}

class FakeUuidGenerator implements UuidGeneratorInterface
{
    public function __construct(private string $uuid) {}
    public function generate(): string { return $this->uuid; }
}

class SyncServiceTest extends TestCase
{
    use ProphecyTrait;

    public function testPushToAppMapsFields(): void
    {
        $profile = new UserProfile();
        $prop = new \ReflectionProperty($profile, 'clock');
        $prop->setAccessible(true);
        $prop->setValue($profile, new FakeClock(new \DateTimeImmutable('2024-01-01T00:00:00+00:00')));
        $prop = new \ReflectionProperty($profile, 'uuidGenerator');
        $prop->setAccessible(true);
        $prop->setValue($profile, new FakeUuidGenerator('abc'));
        $profile->initializeObject();
        $profile->setFeUser(5);
        $profile->setDisplayName('John');
        $profile->setLanguage('de');
        $profile->setCountry('DE');
        $profile->setUpdatedAt(new \DateTimeImmutable('2024-01-01T00:00:00+00:00'));

        $repo = $this->prophesize(UserProfileRepositoryInterface::class);
        $pm = $this->prophesize(PersistenceManagerInterface::class);
        $clock = $this->prophesize(DomainClockInterface::class);
        $service = new SyncService($repo->reveal(), $pm->reveal(), $clock->reveal());

        $data = $service->pushToApp($profile);
        $this->assertSame($profile->getFeUser(), $data['userId']);
        $this->assertSame('abc', $data['uuid']);
    }

    public function testPullFromAppCreatesNewProfile(): void
    {
        $repo = $this->prophesize(UserProfileRepositoryInterface::class);
        $repo->findByUserId(5)->willReturn(null);
        $repo->add(Argument::type(UserProfile::class))->shouldBeCalled();

        $pm = $this->prophesize(PersistenceManagerInterface::class);
        $pm->persistAll()->shouldBeCalled();
        $clock = $this->prophesize(DomainClockInterface::class);
        $clock->now()->willReturn(new \DateTimeImmutable('2024-01-02T00:00:00+00:00'));

        $service = new SyncService($repo->reveal(), $pm->reveal(), $clock->reveal());
        $result = $service->pullFromApp([
            'userId' => 5,
            'updatedAt' => '2024-01-01T00:00:00+00:00'
        ]);
        $this->assertInstanceOf(UserProfile::class, $result);
    }
}
