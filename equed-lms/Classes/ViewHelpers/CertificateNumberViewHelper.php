<?php

declare(strict_types=1);

namespace Equed\EquedLms\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * ViewHelper to format raw certificate numbers with prefix and grouping.
 */
final class CertificateNumberViewHelper extends AbstractViewHelper
{
    public function initializeArguments(): void
    {
        $this->registerArgument(
            'number',
            'string',
            'Raw certificate number',
            true
        );
    }

    /**
     * Renders the certificate number prefixed with "EQ-" and grouped in blocks of four characters.
     *
     * @return string Formatted certificate number, e.g. "EQ-ABCD-EFGH-IJKL"
     */
    public function render(): string
    {
        $raw = strtoupper((string) $this->arguments['number']);
        $grouped = wordwrap($raw, 4, '-', true);

        return sprintf('EQ-%s', $grouped);
    }
}
// EOF
