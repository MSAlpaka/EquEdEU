<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller;

use Equed\Core\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Repository\GlossaryEntryRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Controller for displaying and filtering glossary entries.
 *
 * All output is handled via GPT-based translation with fallback logic.
 */
final class GlossaryController extends ActionController
{
    public function __construct(
        private readonly GlossaryEntryRepository $glossaryEntryRepository,
        private readonly GptTranslationServiceInterface $translationService,
        private readonly Context $context
    ) {
        parent::__construct();
    }

    public function listAction(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $search = trim((string)($queryParams['search'] ?? ''));
        $language = $this->getCurrentLanguage();

        $glossaryEntries = $this->glossaryEntryRepository->findFiltered($language, $search);
        $groupedTerms = $this->groupByInitial($glossaryEntries);

        return $this->htmlResponse([
            'groupedTerms' => $groupedTerms,
            'search' => $search,
        ]);
    }

    protected function groupByInitial(array $entries): array
    {
        $grouped = [];
        foreach ($entries as $entry) {
            $initial = strtoupper(mb_substr($entry->getTerm(), 0, 1));
            $grouped[$initial][] = $entry;
        }
        ksort($grouped);
        return $grouped;
    }

    protected function getCurrentLanguage(): string
    {
        return (string)($this->context->getAspect('language')->get('languageId') ?? 'en');
    }
}
