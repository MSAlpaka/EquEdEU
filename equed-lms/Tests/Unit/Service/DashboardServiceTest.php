<?php

declare(strict_types=1);

namespace {
    if (!class_exists('Equed\\EquedLms\\Domain\\Model\\FrontendUser', false)) {
        class FrontendUser {
            public function getUid(): int { return 0; }
            public function getName(): string { return ''; }
            /** @return array<int,object> */
            public function getUsergroup(): array { return []; }
        }
        class_alias(FrontendUser::class, 'Equed\\EquedLms\\Domain\\Model\\FrontendUser');
    }
    if (!class_exists('Equed\\EquedLms\\Service\\Dashboard\\TabsBuilder', false)) {
        class TabsBuilderStub { public function build($user, array $certs): array { return []; } }
        class_alias(TabsBuilderStub::class, 'Equed\\EquedLms\\Service\\Dashboard\\TabsBuilder');
    }
    if (!class_exists('Equed\\EquedLms\\Service\\Dashboard\\FilterMetadataProvider', false)) {
        class FilterMetadataProviderStub { public function getMetadata(): array { return []; } }
        class_alias(FilterMetadataProviderStub::class, 'Equed\\EquedLms\\Service\\Dashboard\\FilterMetadataProvider');
    }
    if (!class_exists('Equed\\EquedLms\\Service\\Dashboard\\NotificationAggregator', false)) {
        class NotificationAggregatorStub { public function aggregate($user): array { return []; } }
        class_alias(NotificationAggregatorStub::class, 'Equed\\EquedLms\\Service\\Dashboard\\NotificationAggregator');
    }
}

namespace Equed\EquedLms\Tests\Unit\Service {

use DateTimeImmutable;
use Equed\EquedLms\Service\DashboardService;
use Equed\EquedLms\Service\Dashboard\CacheManager;
use Equed\EquedLms\Domain\Repository\CertificateDispatchRepositoryInterface;
use Equed\EquedLms\Service\ProgressServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Service\Dashboard\TabsBuilder;
use Equed\EquedLms\Service\Dashboard\FilterMetadataProvider;
use Equed\EquedLms\Service\Dashboard\NotificationAggregator;
use Equed\EquedLms\Domain\Service\ClockInterface;
use Equed\EquedLms\Dto\DashboardData;
use Equed\EquedLms\Domain\Model\FrontendUser;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Prophecy\Argument;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;

final class DashboardServiceTest extends TestCase
{
    use ProphecyTrait;

    public function testGetDashboardDataReturnsCached(): void
    {
        $user = $this->prophesize(FrontendUser::class);
        $user->getUid()->willReturn(5);

        $cache = new ArrayAdapter();
        $manager = new CacheManager($cache);
        $cached = new DashboardData([], [], [], [], [], [], []);
        $manager->save(5, $cached);

        $certRepo = $this->prophesize(CertificateDispatchRepositoryInterface::class);
        $progress = $this->prophesize(ProgressServiceInterface::class);
        $translator = $this->prophesize(GptTranslationServiceInterface::class);
        $tabs = $this->prophesize(TabsBuilder::class);
        $filters = $this->prophesize(FilterMetadataProvider::class);
        $notes = $this->prophesize(NotificationAggregator::class);
        $clock = $this->prophesize(ClockInterface::class);

        $certRepo->findByFeUser(Argument::cetera())->shouldNotBeCalled();
        $progress->getProgressDataForUser(Argument::cetera())->shouldNotBeCalled();
        $translator->translate(Argument::cetera(), Argument::cetera(), Argument::cetera())->shouldNotBeCalled();
        $tabs->build(Argument::cetera(), Argument::cetera())->shouldNotBeCalled();
        $filters->getMetadata()->shouldNotBeCalled();
        $notes->aggregate(Argument::cetera())->shouldNotBeCalled();
        $clock->now()->shouldNotBeCalled();

        $service = new DashboardService(
            $certRepo->reveal(),
            $progress->reveal(),
            $translator->reveal(),
            true,
            $clock->reveal(),
            $tabs->reveal(),
            $filters->reveal(),
            $notes->reveal(),
            $manager,
        );

        $result = $service->getDashboardDataForUser($user->reveal());

        $this->assertEquals($cached, $result);
    }

    public function testGetDashboardDataCachesResultOnMiss(): void
    {
        $user = $this->prophesize(FrontendUser::class);
        $user->getUid()->willReturn(7)->shouldBeCalledTimes(3);
        $user->getName()->willReturn('John')->shouldBeCalledTimes(1);
        $group = new class { public function getTitle(): string { return 'admin'; } };
        $user->getUsergroup()->willReturn([$group])->shouldBeCalledTimes(1);

        $cache = new ArrayAdapter();
        $manager = new CacheManager($cache);

        $instance = new class {
            public function getUid(): int { return 1; }
        };
        $certificate = new class($instance) {
            public function __construct(private $instance) {}
            public function getCourseInstance() { return $this->instance; }
            public function getCreatedAt(): DateTimeImmutable { return new DateTimeImmutable('2024-01-01'); }
            public function getQrCodeUrl(): string { return 'qr'; }
        };

        $certRepo = $this->prophesize(CertificateDispatchRepositoryInterface::class);
        $certRepo->findByFeUser($user->reveal())->willReturn([$certificate])->shouldBeCalledTimes(1);

        $progress = $this->prophesize(ProgressServiceInterface::class);
        $progress->getProgressDataForUser($user->reveal())->willReturn(['p' => true])->shouldBeCalledTimes(1);

        $translator = $this->prophesize(GptTranslationServiceInterface::class);
        $translator->translate('dashboard.user.name', ['name' => 'John'], null)->willReturn('John')->shouldBeCalledTimes(1);

        $tabs = $this->prophesize(TabsBuilder::class);
        $tabs->build($user->reveal(), Argument::type('array'))->willReturn(['running' => [], 'completed' => []])->shouldBeCalledTimes(1);

        $filters = $this->prophesize(FilterMetadataProvider::class);
        $filters->getMetadata()->willReturn(['f' => 1])->shouldBeCalledTimes(1);

        $notes = $this->prophesize(NotificationAggregator::class);
        $notes->aggregate($user->reveal())->willReturn([['type' => 'note']])->shouldBeCalledTimes(1);

        $clock = $this->prophesize(ClockInterface::class);
        $now = new DateTimeImmutable('2024-06-01T00:00:00+00:00');
        $clock->now()->willReturn($now)->shouldBeCalledTimes(1);

        $service = new DashboardService(
            $certRepo->reveal(),
            $progress->reveal(),
            $translator->reveal(),
            true,
            $clock->reveal(),
            $tabs->reveal(),
            $filters->reveal(),
            $notes->reveal(),
            $manager,
        );

        $first = $service->getDashboardDataForUser($user->reveal());
        $second = $service->getDashboardDataForUser($user->reveal());

        $this->assertEquals($first, $second);
        $this->assertSame('John', $first->getUser()['name']);
        $this->assertSame('2024-06-01T00:00:00+00:00', $first->getCacheMeta()['fetchedAt']);
    }
}
}
