<?php

declare(strict_types=1);

namespace Equed\EquedLms\Dto;

/**
 * Data Transfer Object holding search results.
 */
final class SearchResults
{
    /**
     * @param array<int, array<string, mixed>> $courses
     * @param array<int, array<string, mixed>> $glossary
     */
    public function __construct(
        private readonly array $courses = [],
        private readonly array $glossary = [],
        private readonly ?string $error = null
    ) {
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getCourses(): array
    {
        return $this->courses;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getGlossary(): array
    {
        return $this->glossary;
    }

    public function getError(): ?string
    {
        return $this->error;
    }

    public function hasError(): bool
    {
        return $this->error !== null;
    }
}
