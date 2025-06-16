<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

/**
 * Repository contract for retrieving learning materials by type and category.
 */
interface MaterialRepositoryInterface
{
    /**
     * Find materials filtered by type and category.
     *
     * @param string $type
     * @param string $category
     * @return array<int, mixed>
     */
    public function findByTypeAndCategory(string $type, string $category): array;
}

