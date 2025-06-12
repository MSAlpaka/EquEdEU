<?php

declare(strict_types=1);

namespace Equed\EquedLms\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * ViewHelper to render a styled progress bar with optional label.
 */
final class ProgressBarViewHelper extends AbstractViewHelper
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
            'int',
            'Progress percentage (0–100)',
            true
        );
        $this->registerArgument(
            'label',
            'string',
            'Optional label text; defaults to percentage with %',
            false,
            ''
        );
    }

    /**
     * Renders the progress bar HTML.
     *
     * @return string
     */
    public function render(): string
    {
        $percent = min(100, max(0, (int)$this->arguments['percent']));
        $rawLabel = (string)$this->arguments['label'];

        if ($rawLabel === '') {
            $key = 'progressbar.label.default';
            $translated = $this->translate($key, ['percent' => $percent]);
            $label = $translated ?? $percent . '%';
        } else {
            $label = $rawLabel;
        }

        $escapedLabel = htmlspecialchars($label, ENT_QUOTES);

        return sprintf(
            '<div class="progress-container"><div class="progress-bar" role="progressbar" aria-valuenow="%1$d" style="width:%1$d%%;"></div><span class="progress-label">%2$s</span></div>',
            $percent,
            $escapedLabel
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
