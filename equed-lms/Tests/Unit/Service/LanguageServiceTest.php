<?php

declare(strict_types=1);

namespace TYPO3\CMS\Extbase\Utility;

if (!class_exists(LocalizationUtility::class)) {
    class LocalizationUtility
    {
        public static function translate(string $key, ?string $extension = null, array $arguments = [], ?string $language = null)
        {
            return null;
        }
    }
}

namespace Equed\EquedLms\Service;

if (!interface_exists(GptTranslationServiceInterface::class)) {
    interface GptTranslationServiceInterface
    {
        public function isEnabled(): bool;
        public function translate(string $key, array $arguments = [], ?string $extension = null);
    }
}

if (!interface_exists(\Equed\EquedLms\Domain\Service\TranslatorInterface::class)) {
    interface TranslatorInterface
    {
        public function translate(string $key, array $arguments = [], ?string $extension = null): ?string;
    }
}

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Service\LanguageService;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\TranslatorInterface;
use PHPUnit\Framework\TestCase;

class DummyGptTranslationService implements GptTranslationServiceInterface
{
    public function __construct(private bool $enabled = false)
    {
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function translate(string $key, array $arguments = [], ?string $extension = null): ?string
    {
        return null;
    }
}

class DummyTranslator implements TranslatorInterface
{
    public function translate(string $key, array $arguments = [], ?string $extension = null): ?string
    {
        return null;
    }
}

class LanguageServiceTest extends TestCase
{
    public function testFallbackReturnsKeyWhenTranslationMissing(): void
    {
        $service = new LanguageService(
            new DummyGptTranslationService(false),
            new DummyTranslator()
        );
        $this->assertSame('missing.key', $service->translate('missing.key'));
    }
}
