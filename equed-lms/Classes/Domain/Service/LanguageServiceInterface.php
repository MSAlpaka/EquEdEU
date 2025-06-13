<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Service;

/**
 * Interface for language translation services.
 */
interface LanguageServiceInterface
{
    /**
     * Translate a localization key with optional placeholders.
     */
    public function translate(string $key, array $arguments = [], ?string $extension = null): string;
}
