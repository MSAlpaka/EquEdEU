<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\Lesson;
use Equed\EquedLms\Domain\Model\Asset;
use Equed\EquedLms\Domain\Model\Page;
use Equed\EquedLms\Application\Dto\LessonDto;
use Equed\EquedLms\Application\Assembler\LessonDtoAssembler;
use Equed\EquedLms\Domain\Repository\LessonRepositoryInterface;
use Equed\EquedLms\Service\LessonServiceInterface;
use Psr\Cache\CacheItemPoolInterface;

/**
 * Provides structured lesson data arrays for API consumption.
 *
 * Caches result using PSR-6 cache pool to improve performance.
 */
final class LessonService implements LessonServiceInterface
{
    private const CACHE_TTL_SECONDS = 86400;
    public function __construct(
        private readonly LessonRepositoryInterface $lessonRepository,
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
            'titleKey' => $lesson->getTitleKey(),
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
                    'titleKey' => $page->getTitleKey(),
                ],
                $lesson->getPages()->toArray()
            ),
        ];

        $cacheItem->set($data)->expiresAfter(self::CACHE_TTL_SECONDS);
        $this->cachePool->save($cacheItem);

        return $data;
    }

    /**
     * Finds a lesson by UID and returns its data array.
     */
    public function getLessonDataById(int $lessonId): ?array
    {
        $lesson = $this->lessonRepository->findByUid($lessonId);
        if ($lesson === null) {
            return null;
        }

        return $this->getLessonDataArray($lesson);
    }

    public function getLessonDtoById(int $lessonId): ?LessonDto
    {
        $lesson = $this->lessonRepository->findByUid($lessonId);
        if ($lesson === null) {
            return null;
        }

        return LessonDtoAssembler::fromEntity($lesson);
    }
}
