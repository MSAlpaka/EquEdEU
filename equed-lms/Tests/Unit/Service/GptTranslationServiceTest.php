<?php

declare(strict_types=1);

namespace TYPO3\CMS\Extbase\Utility;

if (!class_exists(LocalizationUtility::class, false)) {
    class LocalizationUtility
    {
        public static function translate(string $key, ?string $extension = null, array $arguments = [], ?string $language = null)
        {
            return null;
        }
    }
}

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Service\GptTranslationService;
use Equed\EquedLms\Service\LogServiceInterface;
use Equed\EquedLms\Domain\Service\TranslatorInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Prophecy\Argument;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;

class GptTranslationServiceTest extends TestCase
{
    use ProphecyTrait;

    public function testTranslateUsesCacheAndGptResult(): void
    {
        $httpClient = new MockHttpClient([
            new MockResponse(json_encode([
                'choices' => [
                    ['message' => ['content' => 'Hallo']]
                ],
            ]), ['http_code' => 200]),
        ]);
        $cache = new ArrayAdapter();
        $logger = $this->prophesize(LogServiceInterface::class);
        $logger->logWarning(Argument::cetera())->shouldNotBeCalled();

        $translator = $this->createMock(TranslatorInterface::class);
        $service = new GptTranslationService(
            $httpClient,
            $cache,
            $logger->reveal(),
            $translator,
            'https://example.com',
            'apikey',
            'en'
        );

        $result1 = $service->translate('hello', ['_language' => 'de']);
        $result2 = $service->translate('hello', ['_language' => 'de']);

        $this->assertSame('Hallo', $result1);
        $this->assertSame('Hallo', $result2);
    }

    public function testTranslateFallsBackToPlaceholderOnError(): void
    {
        $httpClient = new MockHttpClient([
            new MockResponse('', ['http_code' => 500]),
            new MockResponse('', ['http_code' => 500]),
        ]);
        $cache = new ArrayAdapter();
        $logger = $this->prophesize(LogServiceInterface::class);
        $logger->logWarning('GPT translation failed', Argument::type('array'))->shouldBeCalledTimes(2);

        $translator = $this->createMock(TranslatorInterface::class);
        $service = new GptTranslationService(
            $httpClient,
            $cache,
            $logger->reveal(),
            $translator,
            'https://example.com',
            'apikey',
            'en'
        );

        $result = $service->translate('missing.key', ['_language' => 'de']);

        $this->assertSame('[translation missing: missing.key]', $result);
    }
}
