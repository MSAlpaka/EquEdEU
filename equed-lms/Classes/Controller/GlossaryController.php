<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller;

use Equed\EquedLms\Service\GlossaryServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Controller for displaying and filtering glossary entries.
 *
 * All output is handled via GPT-based translation with fallback logic.
 */
final class GlossaryController extends ActionController
{
    public function __construct(
        private readonly GlossaryServiceInterface $glossaryService
    ) {
    }

    public function listAction(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $search = trim((string)($queryParams['search'] ?? ''));

        $groupedTerms = $this->glossaryService->getGroupedTerms($search);

        return $this->htmlResponse([
            'groupedTerms' => $groupedTerms,
            'search' => $search,
        ]);
    }


}
