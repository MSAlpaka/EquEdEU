<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Domain\Model\UserBadge;
use Equed\EquedLms\Domain\Repository\UserBadgeRepositoryInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
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
    private $translation;
    private $clock;

    protected function setUp(): void
    {
        $this->repo = $this->prophesize(UserBadgeRepositoryInterface::class);
        $this->persistence = $this->prophesize(PersistenceManagerInterface::class);
        $this->cache = $this->prophesize(CacheItemPoolInterface::class);
        $this->translation = $this->prophesize(GptTranslationServiceInterface::class);
        $this->clock = $this->prophesize(ClockInterface::class);

        $this->subject = new RecognitionAwardService(
            $this->repo->reveal(),
            $this->persistence->reveal(),
            $this->cache->reveal(),
            $this->translation->reveal(),
            $this->clock->reveal()
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

    public function testAssignRecognitionBadgeCreatesNewBadge(): void
    {
        $this->repo->findByUserAndType(7, 'foo')->willReturn(null);
        $this->translation->isEnabled()->willReturn(false);
        $this->repo->add(\Prophecy\Argument::type(UserBadge::class))->shouldBeCalled();
        $this->persistence->persistAll()->shouldBeCalled();
        $this->cache->deleteItem('qualifyAdvanced_7')->shouldBeCalled();

        $badge = $this->subject->assignRecognitionBadge(7, 'foo');
        $this->assertInstanceOf(UserBadge::class, $badge);
        $this->assertSame('foo', $badge->getType());
    }
}
