<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Service\GptTranslationServiceInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Service for formatting view-related helpers.
 */
final class ViewHelperService
{
    private readonly string $extensionKey;

    public function __construct(
        private readonly GptTranslationServiceInterface $translationService,
        string $extensionKey = 'equed_lms'
    ) {
        $this->extensionKey = $extensionKey;
    }

    /**
     * Returns an HTML progress bar element with the given percentage.
     *
     * @param float $percent Value between 0.0 and 100.0
     * @return string HTML markup for the progress bar
     */
    public function formatProgressBar(float $percent): string
    {
        $clamped = (int) round(min(100.0, max(0.0, $percent)));
        return sprintf(
            '<div class="progress-bar" style="width:%d%%" aria-valuenow="%d"></div>',
            $clamped,
            $clamped
        );
    }

    /**
     * Returns a localized label for a badge identifier.
     *
     * @param string $badgeIdentifier Badge identifier key
     * @return string Localized badge label
     */
    public function badgeLabel(string $badgeIdentifier): string
    {
        $key = sprintf('badge.%s.label', $badgeIdentifier);

        if ($this->translationService->isEnabled()) {
            $translated = $this->translationService->translate($key, [], $this->extensionKey);
            if ($translated !== null && $translated !== $key) {
                return $translated;
            }
        }

        return LocalizationUtility::translate($key, $this->extensionKey) ?? $badgeIdentifier;
    }
}
