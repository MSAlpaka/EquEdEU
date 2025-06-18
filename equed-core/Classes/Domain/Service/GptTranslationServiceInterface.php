<?php

declare(strict_types=1);

namespace Equed\EquedCore\Domain\Service;

interface GptTranslationServiceInterface
{
    public function getApiKey(): string;

    public function getEndpoint(): string;

    public function translate(string $text, string $targetLang): string;
}
