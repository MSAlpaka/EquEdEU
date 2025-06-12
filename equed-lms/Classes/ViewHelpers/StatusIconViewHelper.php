<?php

declare(strict_types=1);

namespace Equed\EquedLms\ViewHelpers;

use Equed\EquedLms\Service\GptTranslationServiceInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * ViewHelper to render a status icon with accessible label.
 */
final class StatusIconViewHelper extends AbstractViewHelper
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
            'status',
            'string',
            'Status string like active, completed, pending',
            true
        );
    }

    /**
     * Renders the status icon as HTML with an ARIA label.
     */
    public function render(): string
    {
        $status = strtolower((string)$this->arguments['status']);
        // Determine label key and icon HTML
        return match ($status) {
            'completed' => $this->renderIcon(
                'completed',
                '&#x2714;'
            ),
            'pending' => $this->renderIcon(
                'pending',
                '&#x26A0;'
            ),
            'active' => $this->renderIcon(
                'active',
                '&#x23F3;'
            ),
            default => $this->renderIcon(
                'unknown',
                '?'
            ),
        };
    }

    /**
     * Helper to render a single icon element with translation.
     *
     * @param string $key    Status key for translation and CSS class
     * @param string $symbol Unicode symbol for the icon
     * @return string
     */
    private function renderIcon(string $key, string $symbol): string
    {
        $translationKey = sprintf('status.icon.%s', $key);
        $label = $this->translate($translationKey, [], $this->extensionKey) ?? ucfirst($key);
        $escapedLabel = htmlspecialchars($label, ENT_QUOTES);

        $class = htmlspecialchars(sprintf('icon %s', $key), ENT_QUOTES);

        return sprintf(
            '<span class="%s" role="img" aria-label="%s">%s</span>',
            $class,
            $escapedLabel,
            $symbol
        );
    }

    /**
     * Translate via GPT-based service with fallback to core localization.
     *
     * @param string $key
     * @param array<string,mixed> $arguments
     * @param string $extensionKey
     * @return string|null
     */
    private function translate(string $key, array $arguments = [], string $extensionKey = ''): ?string
    {
        $extKey = $extensionKey ?: $this->extensionKey;
        if ($this->translationService->isEnabled()) {
            $translated = $this->translationService->translate($key, $arguments, $extKey);
            if ($translated !== null && $translated !== $key) {
                return $translated;
            }
        }

        return LocalizationUtility::translate($key, $extKey, $arguments);
    }
}
// EOF
