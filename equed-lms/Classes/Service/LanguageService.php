<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Service\LanguageServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\TranslatorInterface;

/**
 * Service for translating labels via GPT-based translation service
 * with fallback to TYPO3 core localization.
 */
final class LanguageService implements LanguageServiceInterface
{
    private GptTranslationServiceInterface $gptTranslationService;
    private TranslatorInterface $translator;
    private string $extensionKey;

    public function __construct(
        GptTranslationServiceInterface $gptTranslationService,
        TranslatorInterface $translator,
        string $extensionKey = 'equed_lms'
    ) {
        $this->gptTranslationService = $gptTranslationService;
        $this->translator            = $translator;
        $this->extensionKey          = $extensionKey;
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

        return $this->translator->translate($key, $arguments, $extension) ?? $key;
    }
}
