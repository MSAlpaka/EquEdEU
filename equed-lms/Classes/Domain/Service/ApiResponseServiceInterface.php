<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Service;

interface ApiResponseServiceInterface
{
    /**
     * Builds a successful API response.
     *
     * @param array<string, mixed> $data Optional payload data
     * @param string $messageKey Translation key for the message
     * @param string|null $language ISO language code to translate into
     *
     * @return array<string, mixed>
     */
    public function success(array $data = [], string $messageKey = 'ok', ?string $language = null): array;

    /**
     * Builds an error API response.
     *
     * @param string $messageKey Translation key for the error message
     * @param int $code HTTP-like error code
     * @param string|null $language ISO language code to translate into
     *
     * @return array<string, mixed>
     */
    public function error(string $messageKey = 'error', int $code = 400, ?string $language = null): array;
}

