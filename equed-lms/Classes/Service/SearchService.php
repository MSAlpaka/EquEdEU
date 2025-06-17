<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Dto\SearchResults;
use Equed\EquedLms\Domain\Repository\SearchRepositoryInterface;

/**
 * Provides search capabilities across multiple entities.
 */
final class SearchService implements SearchServiceInterface
{
    public function __construct(
        private readonly SearchRepositoryInterface $searchRepository
    ) {
    }

    /**
     * Performs a global search across relevant tables.
     *
     * @param string $term
     */
    public function search(string $term): SearchResults
    {
        if (mb_strlen($term) < 2) {
            return new SearchResults([], [], 'Search term too short.');
        }

        $courses  = array_map(
            static fn($dto) => $dto->jsonSerialize(),
            $this->searchRepository->searchCourses($term)
        );

        $glossary = array_map(
            static fn($dto) => $dto->jsonSerialize(),
            $this->searchRepository->searchGlossary($term)
        );

        return new SearchResults($courses, $glossary);
    }

}
