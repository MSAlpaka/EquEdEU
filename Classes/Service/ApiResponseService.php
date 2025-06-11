<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Service\GptTranslationServiceInterface;

/**
 * Provides standardized API responses with multilingual support.
 */
final class ApiResponseService
{
    public function __construct(
        private readonly GptTranslationServiceInterface $translationService
    ) {
    }

    /**
     * Builds a successful API response.
     *
     * @param array<string, mixed> $data    Optional payload data.
     * @param string               $messageKey Translation key for the message.
     * @param string|null          $language   ISO language code to translate into; if null, uses default.
     *
     * @return array<string, mixed>
     */
    public function success(array $data = [], string $messageKey = 'ok', ?string $language = null): array
    {
        $lang    = $language ?? $this->translationService->getDefaultLanguage();
        $message = $this->translationService->translate($messageKey, ['_language' => $lang]);

        return [
            'status'  => 'success',
            'message' => $message,
            'data'    => $data,
        ];
    }

    /**
     * Builds an error API response.
     *
     * @param string      $messageKey Translation key for the error message.
     * @param int         $code       HTTP-like error code.
     * @param string|null $language   ISO language code to translate into; if null, uses default.
     *
     * @return array<string, mixed>
     */
    public function error(string $messageKey = 'error', int $code = 400, ?string $language = null): array
    {
        $lang    = $language ?? $this->translationService->getDefaultLanguage();
        $message = $this->translationService->translate($messageKey, ['_language' => $lang]);

        return [
            'status'  => 'error',
            'message' => $message,
            'code'    => $code,
        ];
    }
}
