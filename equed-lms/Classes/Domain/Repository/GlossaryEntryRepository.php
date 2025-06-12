<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

/**
 * Repository for GlossaryEntry entities.

 *
 * @extends Repository<GlossaryEntry>
 */
final class GlossaryEntryRepository extends Repository
{
    /**
     * Finds all glossary terms by language
     *
     * @param string $language
     * @return array
     */
    public function findByLanguage(string $language): array
    {
        $query = $this->createQuery();
        $query->matching($query->equals('language', $language));
        $query->setOrderings(['term' => QueryInterface::ORDER_ASCENDING]);

        return $query->execute()->toArray();
    }

    /**
     * Finds glossary terms filtered by language and optional search term.
     *
     * @param string $language
     * @param string $search
     * @return array
     */
    public function findFiltered(string $language, string $search = ''): array
    {
        $query = $this->createQuery();
        $constraints = [];

        $constraints[] = $query->equals('language', $language);

        if (!empty($search)) {
            $constraints[] = $query->like('term', '%' . $search . '%');
        }

        $query->matching($query->logicalAnd($constraints));
        $query->setOrderings(['term' => QueryInterface::ORDER_ASCENDING]);

        return $query->execute()->toArray();
    }

    /**
     * Finds terms by exact match (e.g. for detail views or glossary linking)
     *
     * @param string $term
     * @param string|null $language
     * @return array
     */
    public function findByExactTerm(string $term, ?string $language = null): array
    {
        $query = $this->createQuery();
        $constraints = [$query->equals('term', $term)];

        if ($language !== null) {
            $constraints[] = $query->equals('language', $language);
        }

        $query->matching($query->logicalAnd($constraints));
        return $query->execute()->toArray();
    }
}
