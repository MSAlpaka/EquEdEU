<?php
declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Dto\CourseSearchResult;
use Equed\EquedLms\Dto\GlossarySearchResult;

interface SearchRepositoryInterface
{
    /**
     * @return CourseSearchResult[]
     */
    public function searchCourses(string $term): array;

    /**
     * @return GlossarySearchResult[]
     */
    public function searchGlossary(string $term): array;
}
