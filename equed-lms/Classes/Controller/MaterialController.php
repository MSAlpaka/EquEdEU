<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller;

use Equed\EquedLms\Domain\Repository\MaterialRepository;
use Equed\Core\Service\GptTranslationServiceInterface;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Controller for listing learning materials (PDF, videos) in Fluid templates.
 *
 * Utilizes hybrid live‐translation via GptTranslationServiceInterface
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 */
final class MaterialController extends ActionController
{
    public function __construct(
        private readonly MaterialRepository          $materialRepository,
        private readonly GptTranslationServiceInterface $translationService,
        private readonly Context                       $context
    ) {
        parent::__construct();
    }

    /**
     * ListAction
     *
     * @return void
     */
    public function listAction(): void
    {
        // Determine UI language and mode
        $language = (string)($this->context->getAspect('frontend.user')->get('language') ?? 'en');
        $mode = $language === 'easy' ? 'simple' : 'expert';

        // Fetch filters from request
        $type = (string)($this->request->getArgument('type') ?? '');
        $category = (string)($this->request->getArgument('category') ?? '');

        // Retrieve materials via repository (uses QueryBuilder internally)
        $materials = $this->materialRepository->findByTypeAndCategory($type, $category);

        // Assign data to Fluid template
        $this->view->assignMultiple([
            'materials'      => $materials,
            'type'           => $type,
            'category'       => $category,
            'mode'           => $mode,
            'labels'         => [
                'heading'        => $this->translationService->translate('material.list.heading', $language),
                'filterType'     => $this->translationService->translate('material.filter.type', $language),
                'filterCategory' => $this->translationService->translate('material.filter.category', $language),
            ],
        ]);
    }
}
// End of file
