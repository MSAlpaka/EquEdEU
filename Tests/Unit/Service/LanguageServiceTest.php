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

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Service\LanguageService;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use PHPUnit\Framework\TestCase;

class DummyTranslationService implements GptTranslationServiceInterface
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

class LanguageServiceTest extends TestCase
{
    public function testFallbackReturnsKeyWhenTranslationMissing(): void
    {
        $service = new LanguageService(new DummyTranslationService(false));
        $this->assertSame('missing.key', $service->translate('missing.key'));
    }
}
