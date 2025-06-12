<?php

declare(strict_types=1);

namespace Equed\EquedLms\ViewHelpers;

use Equed\EquedLms\Service\GptTranslationServiceInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * ViewHelper to render star-based rating (0–5) with accessible label.
 */
final class RatingStarsViewHelper extends AbstractViewHelper
{
    private readonly string $extensionKey;
    private readonly GptTranslationServiceInterface $translationService;

    public function __construct(
        GptTranslationServiceInterface $translationService,
        string $extensionKey = 'equed_lms'
    ) {
        parent::__construct();
        $this->translationService = $translationService;
        $this->extensionKey = $extensionKey;
    }

    public function initializeArguments(): void
    {
        $this->registerArgument(
            'rating',
            'int',
            'Rating value from 0 to 5',
            true
        );
    }

    /**
     * Renders the rating as filled and empty stars, with ARIA label.
     *
     * @return string HTML markup for rating stars
     */
    public function render(): string
    {
        $rating = min(5, max(0, (int)$this->arguments['rating']));
        $filled = str_repeat('★', $rating);
        $empty = str_repeat('☆', 5 - $rating);

        // Accessible label translation
        $key = 'rating.stars.ariaLabel';
        $args = ['rating' => $rating];
        $label = $this->translate($key, $args) ?? sprintf('%d out of 5 stars', $rating);

        $escapedLabel = htmlspecialchars($label, ENT_QUOTES);

        return sprintf(
            '<span class="rating-stars" role="img" aria-label="%s">%s%s</span>',
            $escapedLabel,
            $filled,
            $empty
        );
    }

    /**
     * Translate a key via GPT-based service with fallback.
     */
    private function translate(string $key, array $arguments = []): ?string
    {
        if ($this->translationService->isEnabled()) {
            $translated = $this->translationService->translate($key, $arguments, $this->extensionKey);
            if ($translated !== null && $translated !== $key) {
                return $translated;
            }
        }

        return LocalizationUtility::translate($key, $this->extensionKey, $arguments);
    }
}
// EOF
