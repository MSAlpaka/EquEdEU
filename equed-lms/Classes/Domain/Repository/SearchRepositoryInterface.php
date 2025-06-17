<?php
declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Dto\CourseSearchResult;
use Equed\EquedLms\Dto\GlossarySearchResult;

interface SearchRepositoryInterface
{
    /**
     * Search courses by title or description.
     *
     * @param string $term Search term
     * @return CourseSearchResult[]
     */
    public function searchCourses(string $term): array;

    /**
     * Search glossary terms and definitions.
     *
     * @param string $term Search term
     * @return GlossarySearchResult[]
     */
    public function searchGlossary(string $term): array;
}
