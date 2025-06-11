<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

interface GptTranslationServiceInterface
{
    public function isEnabled(): bool;

    public function translate(string $key, array $arguments = [], ?string $extension = null): ?string;
}
