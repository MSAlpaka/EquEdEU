<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Controller;

use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use Equed\EquedLms\Controller\GlossaryController;
use Equed\EquedLms\Service\GlossaryServiceInterface;
use TYPO3\CMS\Core\View\ViewInterface;
use TYPO3\CMS\Core\Http\HtmlResponse;
use Laminas\Diactoros\ServerRequest;

final class GlossaryControllerTest extends TestCase
{
    use ProphecyTrait;

    private GlossaryController $subject;
    private $glossaryService;
    private $view;

    protected function setUp(): void
    {
        $this->glossaryService = $this->prophesize(GlossaryServiceInterface::class);
        $this->view = $this->prophesize(ViewInterface::class);

        $this->subject = new GlossaryController(
            $this->glossaryService->reveal()
        );
        $this->subject->injectView($this->view->reveal());
    }

    public function testListActionAssignsGlossaryEntries(): void
    {
        $entries = ['A' => []];
        $this->glossaryService->getGroupedTerms('')->willReturn($entries);

        $response = $this->subject->listAction(new ServerRequest());
        $this->assertInstanceOf(HtmlResponse::class, $response);
    }

}
