<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Service;

use Equed\EquedLms\Domain\Model\CourseMaterial;

/**
 * Provides access to course materials.
 */
interface MaterialServiceInterface
{
    /**
     * Returns materials for a specific lesson.
     *
     * @param int $lessonUid
     * @return CourseMaterial[]
     */
    public function getMaterialsForLesson(int $lessonUid): array;

    /**
     * Returns materials for a specific content page.
     *
     * @param int $pageUid
     * @return CourseMaterial[]
     */
    public function getMaterialsForContentPage(int $pageUid): array;

    /**
     * Returns all visible materials.
     *
     * @return CourseMaterial[]
     */
    public function getAllVisibleMaterials(): array;

    /**
     * Returns materials filtered by type.
     *
     * @param string $type
     * @return CourseMaterial[]
     */
    public function getMaterialsByType(string $type): array;
}
