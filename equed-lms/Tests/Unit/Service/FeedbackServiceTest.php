<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Domain\Model\CourseFeedback;
use Equed\EquedLms\Service\FeedbackAnalysisService;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Service\LogServiceInterface;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Http\RequestFactory;

class FeedbackServiceTest extends TestCase
{
    use ProphecyTrait;

    public function testAnalyzeFeedbackReturnsNullWhenDisabled(): void
    {
        $requestFactory = $this->prophesize(RequestFactory::class);
        $logService = $this->prophesize(LogServiceInterface::class);
        $translator = $this->prophesize(GptTranslationServiceInterface::class);

        $service = new FeedbackAnalysisService(
            $requestFactory->reveal(),
            $translator->reveal(),
            $logService->reveal(),
            'key',
            false
        );

        $result = $service->analyzeFeedback(new CourseFeedback());
        $this->assertNull($result);
    }
}
