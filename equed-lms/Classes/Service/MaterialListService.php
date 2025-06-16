<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Repository\MaterialRepositoryInterface;
use Equed\EquedLms\Domain\Service\MaterialListServiceInterface;
use Equed\Core\Service\GptTranslationServiceInterface;
use TYPO3\CMS\Core\Context\Context;

/**
 * Default implementation for building material list view data.
 */
final class MaterialListService implements MaterialListServiceInterface
{
    public function __construct(
        private readonly MaterialRepositoryInterface $materialRepository,
        private readonly GptTranslationServiceInterface $translationService,
        private readonly Context                       $context,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getListData(string $type, string $category): array
    {
        $language = (string)($this->context->getAspect('frontend.user')->get('language') ?? 'en');
        $mode     = $language === 'easy' ? 'simple' : 'expert';

        $materials = $this->materialRepository->findByTypeAndCategory($type, $category);

        return [
            'materials' => $materials,
            'type'      => $type,
            'category'  => $category,
            'mode'      => $mode,
            'labels'    => [
                'heading'        => $this->translationService->translate('material.list.heading', $language),
                'filterType'     => $this->translationService->translate('material.filter.type', $language),
                'filterCategory' => $this->translationService->translate('material.filter.category', $language),
            ],
        ];
    }
}
