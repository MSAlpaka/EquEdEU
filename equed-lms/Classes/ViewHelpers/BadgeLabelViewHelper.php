<?php

declare(strict_types=1);

namespace Equed\EquedLms\ViewHelpers;

use Equed\EquedLms\Domain\Service\LanguageServiceInterface;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * ViewHelper to render a localized badge label.
 */
final class BadgeLabelViewHelper extends AbstractViewHelper
{
    public function __construct(
        private readonly LanguageServiceInterface $languageService
    ) {
    }

    public function initializeArguments(): void
    {
        $this->registerArgument(
            'identifier',
            'string',
            'Badge identifier',
            true
        );
    }

    /**
     * Renders the localized label for the badge identifier.
     *
     * @return string
     */
    public function render(): string
    {
        $identifier = (string)$this->arguments['identifier'];
        $key = sprintf(
            'badge.label.%s',
            strtolower($identifier)
        );

        return $this->languageService->translate($key);
    }
}
// EOF
