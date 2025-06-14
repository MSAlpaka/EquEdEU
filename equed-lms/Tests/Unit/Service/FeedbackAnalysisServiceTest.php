<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Service\FeedbackAnalysisService;
use Equed\EquedLms\Domain\Model\CourseFeedback;
use Psr\Http\Message\ResponseInterface;
use Equed\EquedCore\Service\GptClientInterface;
use Psr\Log\NullLogger;
use Equed\EquedLms\Service\LogService;
use Equed\EquedLms\Service\GptTranslationServiceInterface;

class FeedbackAnalysisServiceTest extends TestCase
{
    public function testAnalyzeFeedbackReturnsMockedResponse(): void
    {
        $feedback = new CourseFeedback();
        $feedback->setOriginalComment('Sehr strukturiertes, klares Feedback.');

        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(
            $this->createConfiguredMock(\Psr\Http\Message\StreamInterface::class, [
                'getContents' => json_encode([
                    'choices' => [
                        [
                            'message' => [
                                'content' => json_encode([
                                    'summary' => 'Klares, strukturiertes Feedback.',
                                    'clusters' => ['Struktur', 'Verst\\xC3\\xA4ndlichkeit'],
                                    'suggestedRating' => 4.8,
                                ]),
                            ],
                        ],
                    ],
                ]),
            ])
        );

        $mockRequestFactory = $this->createMock(GptClientInterface::class);
        $mockRequestFactory->method('postJson')->willReturn($mockResponse);

        $translator = $this->createMock(GptTranslationServiceInterface::class);
        $translator->method('translate')->willReturn('prompt');

        $logService = new LogService(new NullLogger());
        $service = new FeedbackAnalysisService($mockRequestFactory, $translator, $logService, 'key', true);
        $result = $service->analyzeFeedback($feedback);

        $this->assertIsArray($result);
        $this->assertEquals('Klares, strukturiertes Feedback.', $result['summary']);
        $this->assertContains('Struktur', $result['clusters']);
        $this->assertEquals(4.8, $result['suggestedRating']);
    }
}
