<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Service\GptTranslationServiceInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Service for translating labels via GPT-based translation service
 * with fallback to TYPO3 core localization.
 */
final class LanguageService
{
    private GptTranslationServiceInterface $gptTranslationService;
    private string $extensionKey;

    public function __construct(
        GptTranslationServiceInterface $gptTranslationService,
        string $extensionKey = 'equed_lms'
    ) {
        $this->gptTranslationService = $gptTranslationService;
        $this->extensionKey         = $extensionKey;
    }

    /**
     * Translate a localization key with optional placeholders.
     *
     * Tries GPT-based translation if the feature toggle is enabled;
     * otherwise falls back to TYPO3 LocalizationUtility.
     * Returns the key itself if no translation is found.
     *
     * @param string              $key        Localization key
     * @param array<string,mixed> $arguments  Placeholder arguments
     * @param string|null         $extension  Optional extension name
     *
     * @return string
     */
    public function translate(string $key, array $arguments = [], ?string $extension = null): string
    {
        $extension = $extension ?? $this->extensionKey;

        if ($this->gptTranslationService->isEnabled()) {
            $translated = $this->gptTranslationService->translate($key, $arguments, $extension);
            if ($translated !== null && $translated !== $key) {
                return $translated;
            }
        }

        return LocalizationUtility::translate($key, $extension, $arguments) ?? $key;
    }
}
