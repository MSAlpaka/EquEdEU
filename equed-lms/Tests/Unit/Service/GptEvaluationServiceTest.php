<?php

declare(strict_types=1);

namespace TYPO3\CMS\Core\Http {
    if (!class_exists(RequestFactory::class)) {
        class RequestFactory
        {
            public function request(string $url, string $method = 'GET', array $options = [])
            {
                return null;
            }
        }
        class Response
        {
            public function __construct(private string $body) {}
            public function getBody() { return new class($this->body) {
                public function __construct(private string $b) {}
                public function getContents() { return $this->b; }
            }; }
        }
    }
}

namespace Psr\Log {
    if (!interface_exists(LoggerInterface::class)) {
        interface LoggerInterface {
            public function emergency($message, array $context = []);public function alert($message, array $context = []);public function critical($message, array $context = []);public function error($message, array $context = []);public function warning($message, array $context = []);public function notice($message, array $context = []);public function info($message, array $context = []);public function debug($message, array $context = []);
        }
    }
}

namespace Equed\EquedLms\Tests\Unit\Service;

use DateTimeImmutable;
use Equed\EquedLms\Domain\Model\Submission;
use Equed\EquedLms\Domain\Repository\SubmissionRepositoryInterface;
use Equed\EquedLms\Domain\Service\ClockInterface;
use Equed\EquedLms\Service\GptEvaluationService;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Service\LogService;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use TYPO3\CMS\Core\Http\RequestFactory;
use TYPO3\CMS\Core\Http\Response;
use Psr\Log\LoggerInterface;

class GptEvaluationServiceTest extends TestCase
{
    use ProphecyTrait;

    public function testEvaluateSubmissionParsesResponse(): void
    {
        $submission = new Submission();
        $submission->setTextContent(str_repeat('A', 30));

        $repo = $this->prophesize(SubmissionRepositoryInterface::class);
        $repo->update($submission)->shouldBeCalled();

        $requestFactory = $this->prophesize(RequestFactory::class);
        $body = json_encode(['choices' => [['message' => ['content' => json_encode(['suggestedScore' => 4.2, 'summary' => 'Sum', 'suggestion' => 'Sug'])]]]]);
        $requestFactory->request(Argument::cetera())->willReturn(new Response($body));

        $translator = $this->prophesize(GptTranslationServiceInterface::class);
        $translator->translate('submission.evaluation.prompt', ['content' => $submission->getTextContent()])->willReturn('prompt');

        $clock = $this->prophesize(ClockInterface::class);
        $clock->now()->willReturn(new DateTimeImmutable('2024-01-01'));

        $logger = $this->prophesize(LoggerInterface::class);
        $logService = new LogService($logger->reveal());

        $service = new GptEvaluationService(
            $repo->reveal(),
            $requestFactory->reveal(),
            $logService,
            $translator->reveal(),
            'key',
            true,
            'https://api',
            $clock->reveal()
        );

        $result = $service->evaluateSubmission($submission);
        $this->assertIsArray($result);
        $this->assertSame(4.2, $result['suggestedScore']);
    }

    public function testEvaluatePendingDisabled(): void
    {
        $repo = $this->prophesize(SubmissionRepositoryInterface::class);
        $repo->findPendingForAnalysis()->shouldNotBeCalled();

        $requestFactory = $this->prophesize(RequestFactory::class);
        $translator = $this->prophesize(GptTranslationServiceInterface::class);
        $clock = $this->prophesize(ClockInterface::class);
        $logger = $this->prophesize(LoggerInterface::class);
        $logService = new LogService($logger->reveal());

        $service = new GptEvaluationService(
            $repo->reveal(),
            $requestFactory->reveal(),
            $logService,
            $translator->reveal(),
            'key',
            false,
            'https://api',
            $clock->reveal()
        );

        $this->assertSame(0, $service->evaluatePending());
    }
}
