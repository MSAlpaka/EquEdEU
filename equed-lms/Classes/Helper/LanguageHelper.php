<?php

declare(strict_types=1);

namespace Equed\EquedLms\Helper;

use Equed\EquedLms\Enum\LanguageCode;

/**
 * Provides language detection and simple translation messages
 * in accordance with project’s hybrid GPT‐translation requirements.
 */
final class LanguageHelper
{
    /**
     * Detects the preferred language from HTTP Accept headers.
     *
     * @param array<string,string> $serverHeaders HTTP headers, e.g. $_SERVER
     */
    public static function detectLanguage(array $serverHeaders = []): string
    {
        $accept = $serverHeaders['HTTP_ACCEPT_LANGUAGE']
            ?? ($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'en');

        return strtolower(substr($accept, 0, 2));
    }

    /**
     * Returns a localized message for a given key and language.
     * Falls back to English if the language or key is missing.
     *
     * @param string       $key  Message identifier
     * @param LanguageCode $lang Target language
     */
    public static function translate(string $key, LanguageCode $lang): string
    {
        static $messages = [
            'unauthorized' => [
                'de' => 'Nicht autorisiert',
                'fr' => 'Non autorisé',
                'es' => 'No autorizado',
                'sw' => 'Haijaidhinishwa',
                'en' => 'Unauthorized',
            ],
            'invalid_credentials' => [
                'de' => 'Ungültige Zugangsdaten',
                'fr' => 'Identifiants invalides',
                'es' => 'Credenciales inválidas',
                'sw' => 'Maelezo ya kuingia si sahihi',
                'en' => 'Invalid credentials',
            ],
            'not_found' => [
                'de' => 'Nicht gefunden',
                'fr' => 'Non trouvé',
                'es' => 'No encontrado',
                'sw' => 'Haikupatikana',
                'en' => 'Not found',
            ],
        ];

        if (!isset($messages[$key])) {
            return 'Unknown error';
        }

        return $messages[$key][$lang->value]
            ?? $messages[$key][LanguageCode::EN->value];
    }
}
// EOF
