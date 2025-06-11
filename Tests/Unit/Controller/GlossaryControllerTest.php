<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Controller;

use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use Equed\EquedLms\Controller\GlossaryController;
use Equed\EquedLms\Service\GlossaryServiceInterface;
use TYPO3\CMS\Core\View\ViewInterface;
use Psr\Log\LoggerInterface;

final class GlossaryControllerTest extends TestCase
{
    use ProphecyTrait;

    private GlossaryController $subject;
    private $glossaryService;
    private $logger;
    private $view;

    protected function setUp(): void
    {
        $this->glossaryService = $this->prophesize(GlossaryServiceInterface::class);
        $this->logger = $this->prophesize(LoggerInterface::class);
        $this->view = $this->prophesize(ViewInterface::class);

        $this->subject = new GlossaryController(
            $this->glossaryService->reveal(),
            $this->logger->reveal()
        );
        $this->subject->injectView($this->view->reveal());
    }

    public function testListActionAssignsGlossaryEntries(): void
    {
        $entries = ['hoof' => 'Huf', 'frog' => 'Strahl'];
        $this->glossaryService->getAllTerms()->willReturn($entries);

        $this->view->assign('entries', $entries)->shouldBeCalled();

        $this->subject->listAction();
    }

    public function testShowActionAssignsSingleTerm(): void
    {
        $term = ['term' => 'hoof', 'definition' => 'Hornkapsel des Pferdefußes'];
        $this->glossaryService->getTerm('hoof')->willReturn($term);

        $this->view->assign('entry', $term)->shouldBeCalled();

        $this->subject->showAction('hoof');
    }

    public function testShowActionLogsMissingTerm(): void
    {
        $this->glossaryService->getTerm('xyz')->willReturn(null);
        $this->logger->notice('Glossary term not found.', ['term' => 'xyz'])->shouldBeCalled();

        $this->subject->showAction('xyz');
    }
}
