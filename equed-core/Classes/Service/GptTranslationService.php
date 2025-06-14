<?php

declare(strict_types=1);

namespace Equed\EquedCore\Service;

use Equed\EquedCore\Service\GptClientInterface;

class GptTranslationService
{
    /** @internal */
    public const ENV_API_KEY = 'GPT_TRANSLATION_API_KEY';
    /** @internal */
    public const ENV_ENDPOINT = 'GPT_TRANSLATION_ENDPOINT';

    private string $apiKey;
    private string $endpoint;

    public function __construct(
        private readonly GptClientInterface $gptClient,
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
        $response = $this->gptClient->postJson(
            $this->endpoint,
            ['Authorization' => 'Bearer ' . $this->apiKey],
            [
                'text'   => $text,
                'target' => $targetLang,
            ]
        );

        $data = json_decode($response->getBody()->getContents(), true);

        return (string) ($data['translation'] ?? '');
    }
}
