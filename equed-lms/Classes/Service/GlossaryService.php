<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Repository\GlossaryEntryRepository;
use TYPO3\CMS\Core\Context\Context;

final class GlossaryService implements GlossaryServiceInterface
{
    public function __construct(
        private readonly GlossaryEntryRepository $glossaryEntryRepository,
        private readonly Context $context
    ) {
    }

    public function getGroupedTerms(string $search = ''): array
    {
        $language = $this->getCurrentLanguage();
        $entries = $this->glossaryEntryRepository->findFiltered($language, $search);

        return $this->groupByInitial($entries);
    }

    private function getCurrentLanguage(): string
    {
        return (string)($this->context->getAspect('language')->get('languageId') ?? 'en');
    }

    private function groupByInitial(array $entries): array
    {
        $grouped = [];
        foreach ($entries as $entry) {
            $initial = strtoupper(mb_substr($entry->getTerm(), 0, 1));
            $grouped[$initial][] = $entry;
        }
        ksort($grouped);

        return $grouped;
    }
}
