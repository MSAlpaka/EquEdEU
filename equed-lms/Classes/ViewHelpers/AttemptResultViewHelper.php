<?php

declare(strict_types=1);

namespace Equed\EquedLms\ViewHelpers;

use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * ViewHelper to render a label for attempt results based on score percentage.
 */
final class AttemptResultViewHelper extends AbstractViewHelper
{
    /**
     * Initialize arguments.
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('score', 'int', 'Score in percent (0–100)', true);
    }

    /**
     * Renders a localized result label based on the score.
     *
     * @return string Localized result: 'excellent', 'passed', or 'failed'
     */
    public function render(): string
    {
        $score = $this->arguments['score'];
        $key = $score >= 90
            ? 'viewhelper.attemptResult.excellent'
            : (
                $score >= 70
                ? 'viewhelper.attemptResult.passed'
                : 'viewhelper.attemptResult.failed'
            );

        return LocalizationUtility::translate($key, 'equed_lms') ?? $this->getFallbackLabel($key);
    }

    /**
     * Provides fallback labels if translation is missing.
     *
     * @param string $key
     * @return string
     */
    private function getFallbackLabel(string $key): string
    {
        return match ($key) {
            'viewhelper.attemptResult.excellent' => 'excellent',
            'viewhelper.attemptResult.passed'    => 'passed',
            default                              => 'failed',
        };
    }
}
// EOF
