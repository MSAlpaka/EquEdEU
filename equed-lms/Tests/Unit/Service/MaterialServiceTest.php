<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Domain\Repository\CourseMaterialRepositoryInterface;
use Equed\EquedLms\Domain\Model\CourseMaterial;
use Equed\EquedLms\Service\MaterialService;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use PHPUnit\Framework\TestCase;

final class MaterialServiceTest extends TestCase
{
    use ProphecyTrait;

    private MaterialService $subject;
    private $repository;

    protected function setUp(): void
    {
        $this->repository = $this->prophesize(CourseMaterialRepositoryInterface::class);
        $this->subject = new MaterialService(
            $this->repository->reveal()
        );
    }

    public function testReturnsOnlyVisibleMaterials(): void
    {
        $visible = new CourseMaterial();

        $this->repository->findAllVisible()->willReturn([
            $visible,
        ]);

        $result = $this->subject->getAllVisibleMaterials();

        $this->assertSame([$visible], $result);
    }
}
