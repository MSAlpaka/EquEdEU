<?php

declare(strict_types=1);

namespace Equed\EquedLms\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * ViewHelper to render an SVG icon with optional accessibility label.
 */
final class IconViewHelper extends AbstractViewHelper
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
            'identifier',
            'string',
            'Icon identifier, matching the SVG symbol ID',
            true
        );
        $this->registerArgument(
            'size',
            'int',
            'Width and height in pixels',
            false,
            16
        );
        $this->registerArgument(
            'class',
            'string',
            'Additional CSS classes',
            false,
            ''
        );
        $this->registerArgument(
            'label',
            'string',
            'Accessible label; if omitted will be translated',
            false,
            ''
        );
    }

    /**
     * Renders the SVG icon element.
     *
     * @return string
     */
    public function render(): string
    {
        $id    = strtolower((string)$this->arguments['identifier']);
        $size  = (int)$this->arguments['size'];
        $class = trim((string)$this->arguments['class']);
        $label = trim((string)$this->arguments['label']);

        if ($label === '') {
            $key = sprintf('icon.label.%s', $id);
            if ($this->translationService->isEnabled()) {
                $translated = $this->translationService->translate($key, [], $this->extensionKey);
                $label = ($translated !== null && $translated !== $key) ? $translated : '';
            }
            if ($label === '') {
                $label = LocalizationUtility::translate($key, $this->extensionKey) ?? $id;
            }
        }

        $escapedClass = htmlspecialchars($class, ENT_QUOTES);
        $escapedLabel = htmlspecialchars($label, ENT_QUOTES);

        return sprintf(
            '<svg class="icon icon-%1$s%2$s" width="%3$d" height="%3$d" role="img" aria-label="%4$s">'
            . '<use xlink:href="#icon-%1$s"></use></svg>',
            $id,
            $escapedClass !== '' ? ' ' . $escapedClass : '',
            $size,
            $escapedLabel
        );
    }
}
// EOF
