<?php

declare(strict_types=1);

namespace Equed\EquedCore\Service;

use Equed\EquedCore\Service\GptClientInterface;

/**
 * Basic GPT-based translation helper.
 */
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

    /**
     * Retrieve the API key used for requests.
     *
     * @return string API key
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * Retrieve the API endpoint URL.
     *
     * @return string Endpoint URL
     */
    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    /**
     * Translate a string into the requested language.
     *
     * @param string $text       Text to translate
     * @param string $targetLang Target ISO language code
     * @return string Translated text (empty string on failure)
     */
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
