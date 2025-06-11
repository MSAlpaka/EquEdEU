<?php declare(strict_types=1);

namespace Equed\EquedCore\Tests\Unit\Service;

use Equed\EquedCore\Service\GptTranslationService;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class GptTranslationServiceTest extends UnitTestCase
{
    public function testTranslateCreatesRequestAndReturnsContent(): void
    {
        putenv('GPT_TRANSLATION_API_KEY=secret');
        putenv('GPT_TRANSLATION_ENDPOINT=https://api.example.com/translate');

        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())
            ->method('toArray')
            ->willReturn(['translation' => 'Hallo']);

        $client = $this->createMock(HttpClientInterface::class);
        $client->expects($this->once())
            ->method('request')
            ->with(
                'POST',
                'https://api.example.com/translate',
                [
                    'json' => ['text' => 'Hello', 'target' => 'de'],
                    'headers' => ['Authorization' => 'Bearer secret'],
                ]
            )
            ->willReturn($response);

        $service = new GptTranslationService($client);
        $result = $service->translate('Hello', 'de');

        $this->assertSame('Hallo', $result);

        putenv('GPT_TRANSLATION_API_KEY');
        putenv('GPT_TRANSLATION_ENDPOINT');
    }

    public function testConfigurationCanBeOverriddenViaConstructor(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())
            ->method('toArray')
            ->willReturn(['translation' => 'Hola']);

        $client = $this->createMock(HttpClientInterface::class);
        $client->expects($this->once())
            ->method('request')
            ->with(
                'POST',
                'https://gpt.local/translate',
                [
                    'json' => ['text' => 'Hi', 'target' => 'es'],
                    'headers' => ['Authorization' => 'Bearer key123'],
                ]
            )
            ->willReturn($response);

        $service = new GptTranslationService($client, 'key123', 'https://gpt.local/translate');
        $result = $service->translate('Hi', 'es');

        $this->assertSame('Hola', $result);
    }
}
