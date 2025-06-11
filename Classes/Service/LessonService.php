<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\Lesson;
use Equed\EquedLms\Domain\Model\Asset;
use Equed\EquedLms\Domain\Model\Page;
use Equed\EquedLms\Domain\Repository\LessonRepository;
use Psr\Cache\CacheItemPoolInterface;

/**
 * Provides structured lesson data arrays for API consumption.
 *
 * Caches result using PSR-6 cache pool to improve performance.
 */
final class LessonService
{
    public function __construct(
        private readonly LessonRepository $lessonRepository,
        private readonly CacheItemPoolInterface $cachePool
    ) {
    }

    /**
     * Returns lesson data as associative array.
     *
     * @param Lesson $lesson
     * @return array<string, mixed>
     */
    public function getLessonDataArray(Lesson $lesson): array
    {
        $updatedTimestamp = $lesson->getLastModified()?->getTimestamp() ?? 0;
        $cacheKey = sprintf('lessonData_%d_%d', $lesson->getUid(), $updatedTimestamp);

        $cacheItem = $this->cachePool->getItem($cacheKey);
        if ($cacheItem->isHit()) {
            /** @var array<string, mixed> $cached */
            $cached = $cacheItem->get();
            return $cached;
        }

        $data = [
            'id' => $lesson->getUid(),
            'title' => $lesson->getTitle(),
            'updatedAt' => $lesson->getLastModified()?->format('c'),
            'courseId' => $lesson->getCourse()?->getUid(),
            'assets' => array_map(
                fn (Asset $asset): array => [
                    'type' => $asset->getType(),
                    'url' => $asset->getPublicUrl(),
                ],
                $lesson->getAssets()->toArray()
            ),
            'content' => array_map(
                fn (Page $page): array => [
                    'type' => $page->getType(),
                    'value' => $page->getContent(),
                ],
                $lesson->getPages()->toArray()
            ),
        ];

        $cacheItem->set($data);
        $this->cachePool->save($cacheItem);

        return $data;
    }
}
