<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Service\LessonService;
use Equed\EquedLms\Domain\Repository\LessonRepository;
use Equed\EquedLms\Domain\Model\Lesson;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\CacheItemInterface;
use Prophecy\Argument;

final class LessonServiceTest extends TestCase
{
    use ProphecyTrait;

    private LessonService $subject;
    private $repo;
    private $cache;

    protected function setUp(): void
    {
        $this->repo = $this->prophesize(LessonRepository::class);
        $this->cache = $this->prophesize(CacheItemPoolInterface::class);

        $this->subject = new LessonService(
            $this->repo->reveal(),
            $this->cache->reveal()
        );
    }

    public function testGetLessonDataArrayCachesResultWithTtl(): void
    {
        $lesson = $this->prophesize(Lesson::class);
        $lesson->getUid()->willReturn(5);
        $lesson->getTitle()->willReturn('Foo');
        $dt = new \DateTimeImmutable('2024-01-01 00:00:00');
        $lesson->getLastModified()->willReturn($dt);

        $course = new class {
            public function getUid(): int { return 10; }
        };
        $lesson->getCourse()->willReturn($course);
        $lesson->getAssets()->willReturn(new class {
            public function toArray(): array { return []; }
        });
        $lesson->getPages()->willReturn(new class {
            public function toArray(): array { return []; }
        });

        $cacheItem = $this->prophesize(CacheItemInterface::class);
        $cacheItem->isHit()->willReturn(false);
        $cacheItem->set(Argument::type('array'))->willReturn($cacheItem->reveal())->shouldBeCalled();
        $cacheItem->expiresAfter(LessonService::CACHE_TTL_SECONDS)->shouldBeCalled();
        $cacheKey = sprintf('lessonData_%d_%d', 5, $dt->getTimestamp());
        $this->cache->getItem($cacheKey)->willReturn($cacheItem->reveal());
        $this->cache->save($cacheItem->reveal())->shouldBeCalled();

        $result = $this->subject->getLessonDataArray($lesson->reveal());
        $this->assertSame(5, $result['id']);
        $this->assertSame('Foo', $result['title']);
    }
}
