<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\CourseMaterial;
use Equed\EquedLms\Domain\Repository\CourseMaterialRepositoryInterface;

/**
 * Service to retrieve course materials for lessons and content pages.
 */
final class MaterialService
{
    public function __construct(
        private readonly CourseMaterialRepositoryInterface $materialRepository
    ) {
    }

    /**
     * Returns materials for a specific lesson.
     *
     * @param int $lessonUid UID of the lesson
     * @return CourseMaterial[] Array of CourseMaterial objects
     */
    public function getMaterialsForLesson(int $lessonUid): array
    {
        return $this->materialRepository->findByLesson($lessonUid);
    }

    /**
     * Returns materials for a specific content page.
     *
     * @param int $pageUid UID of the content page
     * @return CourseMaterial[] Array of CourseMaterial objects
     */
    public function getMaterialsForContentPage(int $pageUid): array
    {
        return $this->materialRepository->findByContentPage($pageUid);
    }

    /**
     * Returns all visible materials.
     *
     * @return CourseMaterial[] Array of visible CourseMaterial objects
     */
    public function getAllVisibleMaterials(): array
    {
        return $this->materialRepository->findAllVisible();
    }
}
