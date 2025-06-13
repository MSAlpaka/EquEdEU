<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Service\LanguageServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Service\LogService;

/**
 * Helper trait for logging localized error messages.
 */
trait TranslatedLoggerTrait
{
    protected GptTranslationServiceInterface|LanguageServiceInterface $translationService;
    protected LogService $logService;

    public function injectTranslatedLogger(
        GptTranslationServiceInterface|LanguageServiceInterface $translationService,
        LogService $logService
    ): void {
        $this->translationService = $translationService;
        $this->logService = $logService;
    }

    /**
     * Logs a translated error message.
     *
     * @param string               $key    Translation key
     * @param array<string, mixed> $params Placeholder parameters
     */
    protected function logTranslatedError(string $key, array $params = []): void
    {
        $message = $this->translationService->translate($key, $params) ?? $key;
        $this->logService->logError($message);
    }
}
