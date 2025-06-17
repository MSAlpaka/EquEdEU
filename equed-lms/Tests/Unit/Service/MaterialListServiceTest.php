<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Domain\Repository\MaterialRepositoryInterface;
use Equed\EquedLms\Service\MaterialListService;
use Equed\Core\Service\GptTranslationServiceInterface;
use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;

final class MaterialListServiceTest extends TestCase
{
    use ProphecyTrait;

    private MaterialListService $subject;
    private $repository;
    private $translator;

    protected function setUp(): void
    {
        $this->repository = $this->prophesize(MaterialRepositoryInterface::class);
        $this->translator = $this->prophesize(GptTranslationServiceInterface::class);

        $context = new class() {
            public function getAspect(string $name)
            {
                return new class() {
                    public function get(string $key)
                    {
                        return 'en';
                    }
                };
            }
        };

        $this->subject = new MaterialListService(
            $this->repository->reveal(),
            $this->translator->reveal(),
            $context
        );
    }

    public function testReturnsListData(): void
    {
        $materials = ['m1'];

        $this->repository->findByTypeAndCategory('pdf', 'general')->willReturn($materials);
        $args = ['_language' => 'en'];
        $this->translator->translate('material.list.heading', $args)->willReturn('h');
        $this->translator->translate('material.filter.type', $args)->willReturn('t');
        $this->translator->translate('material.filter.category', $args)->willReturn('c');

        $result = $this->subject->getListData('pdf', 'general');

        $expected = [
            'materials' => $materials,
            'type' => 'pdf',
            'category' => 'general',
            'mode' => 'expert',
            'labels' => [
                'heading' => 'h',
                'filterType' => 't',
                'filterCategory' => 'c',
            ],
        ];

        $this->assertSame($expected, $result);
    }
}

