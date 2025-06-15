<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

/**
 * Contract for GPT-based translation helpers.
 */
interface GptTranslationServiceInterface
{
    /**
     * Determine whether GPT translations are enabled.
     */
    public function isEnabled(): bool;

    /**
     * Translate the given key using GPT.
     *
     * @param string               $key       Translation key
     * @param array<string,mixed>  $arguments Placeholder arguments
     * @param string|null          $extension Optional extension key
     * @return string|null Translated string or null if unavailable
     */
    public function translate(string $key, array $arguments = [], ?string $extension = null): ?string;
}
