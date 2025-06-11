<?php

declare(strict_types=1);

namespace Equed\EquedLms\ViewHelper;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * ViewHelper to render a course title with optional level, with localization support.
 */
final class CourseTitleViewHelper extends AbstractViewHelper
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
            'title',
            'string',
            'Base title of the course',
            true
        );
        $this->registerArgument(
            'level',
            'string',
            'Course level or type (optional)',
            false,
            ''
        );
    }

    /**
     * Renders the localized course title, appending level in parentheses if provided.
     *
     * @return string
     */
    public function render(): string
    {
        $rawTitle = (string)$this->arguments['title'];
        $rawLevel = (string)$this->arguments['level'];

        $title = $this->translate('course.title.' . strtolower($rawTitle)) ?? $rawTitle;
        $level = $rawLevel !== ''
            ? ($this->translate('course.level.' . strtolower($rawLevel)) ?? $rawLevel)
            : '';

        $escapedTitle = htmlspecialchars(trim($title), ENT_QUOTES);
        if ($level !== '') {
            $escapedLevel = htmlspecialchars(trim($level), ENT_QUOTES);
            return sprintf('%s (%s)', $escapedTitle, $escapedLevel);
        }

        return $escapedTitle;
    }

    /**
     * Translate a key via GPT-based service with fallback to core localization.
     *
     * @param string $key
     * @param array<string,mixed> $arguments
     * @return string|null
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
