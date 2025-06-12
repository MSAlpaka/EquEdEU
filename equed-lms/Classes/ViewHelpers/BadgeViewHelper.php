<?php

declare(strict_types=1);

namespace Equed\EquedLms\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use Equed\EquedLms\Service\LanguageServiceInterface;

/**
 * ViewHelper to render a localized badge label based on its identifier.
 */
final class BadgeViewHelper extends AbstractViewHelper
{
    public function __construct(
        private readonly LanguageServiceInterface $languageService
    ) {
        parent::__construct();
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
     * Returns the localized label for the badge identifier.
     *
     * @return string
     */
    public function render(): string
    {
        $identifier = (string)$this->arguments['identifier'];
        $key = sprintf('badge.label.%s', strtolower($identifier));

        return $this->languageService->translate($key);
    }
}
// EOF
