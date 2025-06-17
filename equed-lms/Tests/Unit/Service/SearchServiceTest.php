<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository {
    use Equed\EquedLms\Dto\CourseSearchResult;
    use Equed\EquedLms\Dto\GlossarySearchResult;

    interface SearchRepositoryInterface
    {
        /** @return CourseSearchResult[] */
        public function searchCourses(string $term): array;

        /** @return GlossarySearchResult[] */
        public function searchGlossary(string $term): array;
    }

    class NullSearchRepository implements SearchRepositoryInterface
    {
        public function searchCourses(string $term): array { return []; }
        public function searchGlossary(string $term): array { return []; }
    }
}

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Service\SearchService;
use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Domain\Repository\NullSearchRepository;

final class SearchServiceTest extends TestCase
{
    public function testReturnsErrorForTooShortTerm(): void
    {
        $service = new SearchService(new NullSearchRepository());
        $result = $service->search('a');
        $this->assertTrue($result->hasError());
        $this->assertSame('Search term too short.', $result->getError());
    }
}
