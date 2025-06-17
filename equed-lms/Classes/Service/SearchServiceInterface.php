<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Dto\SearchResults;

interface SearchServiceInterface
{
    public function search(string $term): SearchResults;
}
