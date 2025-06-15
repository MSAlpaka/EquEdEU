<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

interface GlossaryServiceInterface
{
    /**
     * Retrieve glossary entries grouped by their initial letter for the
     * current language.
     *
     * @param string $search Optional search term
     * @return array<string, array<\Equed\EquedLms\Domain\Model\GlossaryEntry>>
     */
    public function getGroupedTerms(string $search = ''): array;
}
