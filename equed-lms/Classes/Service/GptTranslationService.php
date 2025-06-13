<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Psr\Cache\CacheItemPoolInterface;
use Equed\EquedLms\Service\LogService;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Equed\EquedLms\Domain\Service\TranslatorInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;

final class GptTranslationService implements GptTranslationServiceInterface
{
    private const CACHE_TTL = 3600;

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly CacheItemPoolInterface $cache,
        private readonly LogService $logService,
        private readonly TranslatorInterface $translator,
        private readonly string $apiEndpoint,
        private readonly string $apiKey,
        private readonly string $defaultLanguage = 'en'
    ) {
    }

    public function isEnabled(): bool
    {
        return $this->apiKey !== '';
    }

    public function getDefaultLanguage(): string
    {
        return $this->defaultLanguage;
    }

    public function detectLanguage(?string $acceptLanguage): ?string
    {
        if ($acceptLanguage === null || $acceptLanguage === '') {
            return null;
        }

        return strtolower(substr($acceptLanguage, 0, 2));
    }

    /**
     * Translate a localization key with layered fallbacks.
     *
     * @param string              $key       Translation key
     * @param array<string, mixed> $arguments Placeholder arguments. Special key
     *                                       '_language' can be used to specify
     *                                       the target language.
     * @param string|null         $extension Optional extension name
     */
    public function translate(string $key, array $arguments = [], ?string $extension = null): ?string
    {
        $language = strtolower((string)($arguments['_language'] ?? $this->defaultLanguage));
        unset($arguments['_language']);

        $cacheKey = 'gpt_translation_' . md5($language . '|' . $key);
        $item = $this->cache->getItem($cacheKey);
        if ($item->isHit()) {
            return (string)$item->get();
        }

        // 2) static XLIFF
        $static = $this->translator->translate($key, $arguments, $extension ?? 'equed_lms');
        if ($static !== null) {
            $item->set($static)->expiresAfter(self::CACHE_TTL);
            $this->cache->save($item);
            return $static;
        }

        // 3) live GPT
        try {
            $gptResult = $this->callGptApi($key, $language);
            if ($gptResult !== '') {
                $item->set($gptResult)->expiresAfter(self::CACHE_TTL);
                $this->cache->save($item);
                return $gptResult;
            }
        } catch (\Throwable $e) {
            $this->logService->logWarning(
                'GPT translation failed',
                ['key' => $key, 'language' => $language, 'exception' => $e]
            );
        }

        // 4) fallback to default language
        if ($language !== $this->defaultLanguage) {
            return $this->translate($key, ['_language' => $this->defaultLanguage], $extension);
        }

        // 5) final placeholder
        $fallback = "[translation missing: {$key}]";
        $item->set($fallback)->expiresAfter(self::CACHE_TTL);
        $this->cache->save($item);
        return $fallback;
    }

    /**
     * Call the external GPT API to translate a single key.
     *
     * @param string $key
     * @param string $language
     * @return string
     */
    private function callGptApi(string $key, string $language): string
    {
        $payload = [
            'model' => 'gpt-4o-mini',
            'messages' => [
                ['role' => 'system', 'content' => "Translate the following key into {$language}:"],
                ['role' => 'user', 'content' => $key],
            ],
            'temperature' => 0.3,
        ];

        $response = $this->httpClient->request(
            'POST',
            $this->apiEndpoint,
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => $payload,
            ]
        );

        if ($response->getStatusCode() !== 200) {
            throw new \RuntimeException('GPT API returned HTTP ' . $response->getStatusCode());
        }

        $data = $response->toArray(false);
        return $data['choices'][0]['message']['content'] ?? '';
    }
}
