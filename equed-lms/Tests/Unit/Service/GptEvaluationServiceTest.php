<?php

declare(strict_types=1);


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
use Psr\Http\Message\ResponseInterface;
use Equed\EquedCore\Service\GptClientInterface;
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

        $gptClient = $this->prophesize(GptClientInterface::class);
        $body = json_encode([
            'choices' => [[
                'message' => ['content' => json_encode(['suggestedScore' => 4.2, 'summary' => 'Sum', 'suggestion' => 'Sug'])]
            ]]
        ]);
        $response = $this->createConfiguredMock(ResponseInterface::class, [
            'getBody' => $this->createConfiguredMock(\Psr\Http\Message\StreamInterface::class, [
                'getContents' => $body,
            ])
        ]);
        $gptClient->postJson(Argument::cetera())->willReturn($response);

        $translator = $this->prophesize(GptTranslationServiceInterface::class);
        $translator->translate('submission.evaluation.prompt', ['content' => $submission->getTextContent()])->willReturn('prompt');

        $clock = $this->prophesize(ClockInterface::class);
        $clock->now()->willReturn(new DateTimeImmutable('2024-01-01'));

        $logger = $this->prophesize(LoggerInterface::class);
        $logService = new LogService($logger->reveal());

        $service = new GptEvaluationService(
            $repo->reveal(),
            $gptClient->reveal(),
            $translator->reveal(),
            $logService,
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

        $gptClient = $this->prophesize(GptClientInterface::class);
        $translator = $this->prophesize(GptTranslationServiceInterface::class);
        $clock = $this->prophesize(ClockInterface::class);
        $logger = $this->prophesize(LoggerInterface::class);
        $logService = new LogService($logger->reveal());

        $service = new GptEvaluationService(
            $repo->reveal(),
            $gptClient->reveal(),
            $translator->reveal(),
            $logService,
            'key',
            false,
            'https://api',
            $clock->reveal()
        );

        $this->assertSame(0, $service->evaluatePending());
    }
}
