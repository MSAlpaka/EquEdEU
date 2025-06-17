<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Domain\Model\UserBadge;
use Equed\EquedLms\Domain\Repository\UserBadgeRepositoryInterface;
use Equed\EquedLms\Domain\Service\LanguageServiceInterface;
use Equed\EquedLms\Service\RecognitionAwardService;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\CacheItemInterface;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use Equed\EquedLms\Domain\Service\ClockInterface;

class RecognitionAwardServiceTest extends TestCase
{
    use ProphecyTrait;

    private RecognitionAwardService $subject;
    private $repo;
    private $persistence;
    private $cache;
    private $language;
    private $clock;

    protected function setUp(): void
    {
        $this->repo = $this->prophesize(UserBadgeRepositoryInterface::class);
        $this->persistence = $this->prophesize(PersistenceManagerInterface::class);
        $this->cache = $this->prophesize(CacheItemPoolInterface::class);
        $this->language = $this->prophesize(LanguageServiceInterface::class);
        $this->clock = $this->prophesize(ClockInterface::class);

        $this->subject = new RecognitionAwardService(
            $this->repo->reveal(),
            $this->persistence->reveal(),
            $this->cache->reveal(),
            $this->language->reveal(),
            $this->clock->reveal(),
            1800
        );
    }

    public function testQualifiesForAdvancedTitleUsesCache(): void
    {
        $item = $this->prophesize(CacheItemInterface::class);
        $item->isHit()->willReturn(true);
        $item->get()->willReturn(true);
        $this->cache->getItem('qualifyAdvanced_5')->willReturn($item->reveal());
        $this->repo->countValidBadges(\Prophecy\Argument::any())->shouldNotBeCalled();

        $this->assertTrue($this->subject->qualifiesForAdvancedTitle(5));
    }

    public function testQualifiesForAdvancedTitleCachesResult(): void
    {
        $item = $this->prophesize(CacheItemInterface::class);
        $item->isHit()->willReturn(false);
        $item->set(true)->willReturn($item->reveal())->shouldBeCalled();
        $item->expiresAfter(1800)->shouldBeCalled();
        $this->cache->getItem('qualifyAdvanced_3')->willReturn($item->reveal());
        $this->repo->countValidBadges(3)->willReturn(5);
        $this->cache->save($item->reveal())->shouldBeCalled();

        $this->assertTrue($this->subject->qualifiesForAdvancedTitle(3));
    }

    public function testAssignRecognitionBadgeCreatesNewBadge(): void
    {
        $this->repo->findByUserAndType(7, 'foo')->willReturn(null);
        $this->language->translate(\Prophecy\Argument::any(), \Prophecy\Argument::cetera())->willReturn('');
        $this->repo->add(\Prophecy\Argument::type(UserBadge::class))->shouldBeCalled();
        $this->persistence->persistAll()->shouldBeCalled();
        $this->cache->deleteItem('qualifyAdvanced_7')->shouldBeCalled();

        $badge = $this->subject->assignRecognitionBadge(7, 'foo');
        $this->assertInstanceOf(UserBadge::class, $badge);
        $this->assertSame('foo', $badge->getType());
    }
}
