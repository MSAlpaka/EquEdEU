<?php

declare(strict_types=1);

namespace Ramsey\Uuid { if (!class_exists(Uuid::class)) { class Uuid { public static function uuid4(){ return new class { public function toString(){ return 'generated'; } }; } } } }

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Domain\Model\UserProfile;
use Equed\EquedLms\Domain\Repository\UserProfileRepositoryInterface;
use Equed\EquedLms\Service\SyncService;
use Equed\EquedLms\Domain\Service\ClockInterface;
use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use Prophecy\Argument;

class SyncServiceTest extends TestCase
{
    use ProphecyTrait;

    public function testPushToAppMapsFields(): void
    {
        $profile = new UserProfile();
        $profile->setUuid('abc');
        $profile->setFeUser(5);
        $profile->setDisplayName('John');
        $profile->setLanguage('de');
        $profile->setCountry('DE');
        $profile->setUpdatedAt(new \DateTimeImmutable('2024-01-01T00:00:00+00:00'));

        $repo = $this->prophesize(UserProfileRepositoryInterface::class);
        $pm = $this->prophesize(PersistenceManagerInterface::class);
        $clock = $this->prophesize(ClockInterface::class);
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
        $clock = $this->prophesize(ClockInterface::class);

        $service = new SyncService($repo->reveal(), $pm->reveal(), $clock->reveal());
        $result = $service->pullFromApp([
            'userId' => 5,
            'updatedAt' => '2024-01-01T00:00:00+00:00'
        ]);
        $this->assertInstanceOf(UserProfile::class, $result);
    }
}
