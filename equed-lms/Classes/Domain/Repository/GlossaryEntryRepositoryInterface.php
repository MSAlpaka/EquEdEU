<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use Equed\EquedLms\Domain\Model\GlossaryEntry;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

interface GlossaryEntryRepositoryInterface
{
    /**
     * @param string $language
     * @return GlossaryEntry[]
     */
    public function findByLanguage(string $language): array;

    /**
     * @param string $language
     * @param string $search
     * @return GlossaryEntry[]
     */
    public function findFiltered(string $language, string $search = ''): array;

    /**
     * @param string      $term
     * @param string|null $language
     * @return GlossaryEntry[]
     */
    public function findByExactTerm(string $term, ?string $language = null): array;

    /**
     * @return QueryInterface<GlossaryEntry>
     */
    public function createQuery(): QueryInterface;
}

