<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Service\FeedbackAnalysisService;
use Equed\EquedLms\Domain\Model\Feedback;
use TYPO3\CMS\Core\Http\RequestFactory;
use Psr\Log\NullLogger;
use Equed\EquedLms\Service\LogService;
use TYPO3\CMS\Core\Configuration\ConfigurationManager;

class FeedbackAnalysisServiceTest extends TestCase
{
    public function testAnalyzeFeedbackReturnsMockedResponse(): void
    {
        $feedback = new Feedback();
        $feedback->setOriginalComment('Sehr strukturiertes, klares Feedback.');

        $mockRequestFactory = $this->createMock(RequestFactory::class);
        $mockRequestFactory->method('request')->willReturn(new class () {
            public function getBody()
            {
                return new class () {
                    public function getContents()
                    {
                        return json_encode([
                            'choices' => [
                                [
                                    'message' => [
                                        'content' => json_encode([
                                            'summary' => 'Klares, strukturiertes Feedback.',
                                            'clusters' => ['Struktur', 'Verständlichkeit'],
                                            'suggestedRating' => 4.8,
                                        ]),
                                    ],
                                ],
                            ],
                        ]);
                    }
                };
            }
        });

        $mockConfigManager = $this->createMock(ConfigurationManager::class);
        $mockConfigManager->method('getConfiguration')->willReturn([]);

        $logService = new LogService(new NullLogger());
        $service = new FeedbackAnalysisService($mockRequestFactory, $logService, $mockConfigManager);
        $result = $service->analyzeFeedback($feedback);

        $this->assertIsArray($result);
        $this->assertEquals('Klares, strukturiertes Feedback.', $result['summary']);
        $this->assertContains('Struktur', $result['clusters']);
        $this->assertEquals(4.8, $result['suggestedRating']);
    }
}
