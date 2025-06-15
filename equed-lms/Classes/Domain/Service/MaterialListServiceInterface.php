<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Service;

/**
 * Provides learning material list data including translations and mode.
 */
interface MaterialListServiceInterface
{
    /**
     * Prepare data for the material list view.
     *
     * @param string $type
     * @param string $category
     * @return array<string, mixed>
     */
    public function getListData(string $type, string $category): array;
}
