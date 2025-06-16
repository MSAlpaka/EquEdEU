<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Service\ExamService;
use Equed\EquedLms\Domain\Repository\ExamAttemptRepositoryInterface;
use Equed\EquedLms\Factory\ExamAttemptFactoryInterface;
use Equed\EquedLms\Domain\Service\ClockInterface;
use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;

class ExamServiceTest extends TestCase
{
    use ProphecyTrait;

    public function testLoadTemplateUsesInjectedBasePath(): void
    {
        $base = sys_get_temp_dir() . '/exam_service_test';
        if (!is_dir($base)) {
            mkdir($base);
        }
        file_put_contents($base . '/5.json', json_encode(['foo' => 'bar']));

        $repo = $this->prophesize(ExamAttemptRepositoryInterface::class);
        $factory = $this->prophesize(ExamAttemptFactoryInterface::class);
        $clock = $this->prophesize(ClockInterface::class);

        $service = new ExamService(
            $repo->reveal(),
            $factory->reveal(),
            $clock->reveal(),
            $base
        );

        $data = $service->loadTemplate(5);

        $this->assertSame(['foo' => 'bar'], $data);

        unlink($base . '/5.json');
        rmdir($base);
    }
}
