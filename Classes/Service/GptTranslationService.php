<?php

declare(strict_types=1);

namespace Equed\EquedCore\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GptTranslationService
{
    /** @internal */
    public const ENV_API_KEY = 'GPT_TRANSLATION_API_KEY';
    /** @internal */
    public const ENV_ENDPOINT = 'GPT_TRANSLATION_ENDPOINT';

    private string $apiKey;
    private string $endpoint;

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        ?string $apiKey = null,
        ?string $endpoint = null,
    ) {
        $this->apiKey = $apiKey ?? (string) getenv(self::ENV_API_KEY);
        $this->endpoint = $endpoint ?? (string) getenv(self::ENV_ENDPOINT);
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    public function translate(string $text, string $targetLang): string
    {
        $response = $this->httpClient->request('POST', $this->endpoint, [
            'json' => [
                'text' => $text,
                'target' => $targetLang,
            ],
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
            ],
        ]);

        $data = $response->toArray();

        return (string) ($data['translation'] ?? '');
    }
}
