<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use Equed\EquedLms\Service\ApiResponseService;
use Equed\EquedLms\Service\GptTranslationServiceInterface;

class ApiResponseServiceTest extends TestCase
{
    use ProphecyTrait;

    private ApiResponseService $subject;
    private $translationService;

    protected function setUp(): void
    {
        $this->translationService = $this->prophesize(GptTranslationServiceInterface::class);
        $this->translationService->getDefaultLanguage()->willReturn('en');
        $this->translationService->translate(Argument::cetera())->will(function ($args) {
            return $args[0];
        });

        $this->subject = new ApiResponseService(
            $this->translationService->reveal()
        );
    }

    public function testItReturnsSuccessfulResponse(): void
    {
        $payload = ['foo' => 'bar'];
        $result = $this->subject->success($payload);

        $this->assertIsArray($result);
        $this->assertSame('success', $result['status']);
        $this->assertSame($payload, $result['data']);
    }

    public function testItReturnsFailureResponse(): void
    {
        $message = 'Something went wrong';
        $code = 400;
        $result = $this->subject->error($message, $code);

        $this->assertIsArray($result);
        $this->assertSame('error', $result['status']);
        $this->assertSame($message, $result['message']);
        $this->assertSame($code, $result['code']);
    }

    public function testEmptySuccessDefaultsToEmptyData(): void
    {
        $result = $this->subject->success();

        $this->assertArrayHasKey('data', $result);
        $this->assertSame([], $result['data']);
    }
}
