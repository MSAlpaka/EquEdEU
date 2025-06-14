<?php declare(strict_types=1);

namespace Equed\EquedCore\Tests\Unit\Service;

use Equed\EquedCore\Service\GptTranslationService;
use Psr\Http\Message\ResponseInterface;
use Equed\EquedCore\Service\GptClientInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class GptTranslationServiceTest extends UnitTestCase
{
    public function testTranslateCreatesRequestAndReturnsContent(): void
    {
        putenv('GPT_TRANSLATION_API_KEY=secret');
        putenv('GPT_TRANSLATION_ENDPOINT=https://api.example.com/translate');

        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())
            ->method('getBody')
            ->willReturn($this->createConfiguredMock(\Psr\Http\Message\StreamInterface::class, [
                'getContents' => json_encode(['translation' => 'Hallo']),
            ]));

        $client = $this->createMock(GptClientInterface::class);
        $client->expects($this->once())
            ->method('postJson')
            ->with(
                'https://api.example.com/translate',
                ['Authorization' => 'Bearer secret'],
                ['text' => 'Hello', 'target' => 'de']
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
            ->method('getBody')
            ->willReturn($this->createConfiguredMock(\Psr\Http\Message\StreamInterface::class, [
                'getContents' => json_encode(['translation' => 'Hola']),
            ]));

        $client = $this->createMock(GptClientInterface::class);
        $client->expects($this->once())
            ->method('postJson')
            ->with(
                'https://gpt.local/translate',
                ['Authorization' => 'Bearer key123'],
                ['text' => 'Hi', 'target' => 'es']
            )
            ->willReturn($response);

        $service = new GptTranslationService($client, 'key123', 'https://gpt.local/translate');
        $result = $service->translate('Hi', 'es');

        $this->assertSame('Hola', $result);
    }
}
