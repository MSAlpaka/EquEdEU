<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\CourseMaterial;

interface CourseMaterialRepositoryInterface
{
    /**
     * Find a CourseMaterial by its UUID.
     *
     * @param string $uuid
     * @return CourseMaterial|null
     */
    public function findByUuid(string $uuid): ?CourseMaterial;

    /**
     * Find all CourseMaterial records that are not deleted.
     *
     * @return CourseMaterial[]
     */
    public function findAllActive(): array;

    /**
     * Find all CourseMaterial records that are visible.
     *
     * @return CourseMaterial[]
     */
    public function findAllVisible(): array;

    /**
     * Find all CourseMaterial records by type.
     *
     * @param string $type
     * @return CourseMaterial[]
     */
    public function findByType(string $type): array;
}
