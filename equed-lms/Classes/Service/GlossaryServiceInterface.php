<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

interface GlossaryServiceInterface
{
    /**
     * @return array<array-key, mixed>
     */
    public function getAllTerms(): array;

    /**
     * @return array<array-key, mixed>|null
     */
    public function getTerm(string $term): array|null;
}
