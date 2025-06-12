<?php

declare(strict_types=1);

namespace Equed\EquedLms\ViewHelpers;

use Equed\EquedLms\Service\GptTranslationServiceInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * ViewHelper to render a simple progress bar.
 */
final class ProgressViewHelper extends AbstractViewHelper
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
            'percent',
            'float',
            'Progress percentage value between 0 and 100',
            true
        );
        $this->registerArgument(
            'showLabel',
            'bool',
            'Whether to show percentage label inside the bar',
            false,
            false
        );
    }

    /**
     * Renders the progress bar HTML.
     *
     * @return string
     */
    public function render(): string
    {
        $rawPercent = (float)$this->arguments['percent'];
        $percent = min(100.0, max(0.0, $rawPercent));
        $showLabel = (bool)$this->arguments['showLabel'];

        // Determine accessible label
        $labelKey = 'progressbar.ariaLabel';
        $label = $this->translate($labelKey, ['percent' => $percent])
            ?? sprintf('%d%%', (int)round($percent));

        $escapedLabel = htmlspecialchars($label, ENT_QUOTES);

        $barHtml = sprintf(
            '<div class="progress-container" role="progressbar" aria-valuenow="%1$d" aria-label="%2$s">'
            . '<div class="progress-bar" style="width:%1$d%%;"></div>',
            (int)round($percent),
            $escapedLabel
        );

        if ($showLabel) {
            $barHtml .= sprintf(
                '<span class="progress-label">%s</span>',
                htmlspecialchars(sprintf('%d%%', (int)round($percent)), ENT_QUOTES)
            );
        }

        $barHtml .= '</div>';

        return $barHtml;
    }

    /**
     * Translate via GPT-based service with fallback to core localization.
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
