<?php declare(strict_types=1);

namespace Equed\EquedCore\Tests\Unit\Controller;

use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Equed\EquedCore\Controller\DocumentUploadController;
use Equed\EquedCore\Domain\Repository\DocumentUploadRepository;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Core\Localization\LanguageService;
use Equed\EquedCore\Domain\Model\DocumentUpload;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;

class DocumentUploadControllerTest extends UnitTestCase
{
    private function createController(LanguageService $translator): DocumentUploadController
    {
        $repository = $this->createMock(DocumentUploadRepository::class);
        $persistenceManager = $this->createMock(PersistenceManager::class);

        return $this->getMockBuilder(DocumentUploadController::class)
            ->setConstructorArgs([$repository, $persistenceManager, $translator])
            ->onlyMethods(['addFlashMessage', 'redirect'])
            ->getMock();
    }

    public function testCreateActionUsesTranslator(): void
    {
        $translator = $this->createMock(LanguageService::class);
        $translator->expects($this->once())
            ->method('sL')
            ->with('LLL:EXT:equed_core/Resources/Private/Language/locallang_db.xlf:documentupload.created')
            ->willReturn('translated');

        $controller = $this->createController($translator);
        $controller->expects($this->once())
            ->method('addFlashMessage')
            ->with('translated', '', ContextualFeedbackSeverity::OK);
        $controller->expects($this->once())
            ->method('redirect')
            ->with('list');

        $document = $this->createMock(DocumentUpload::class);
        $document->expects($this->once())->method('onCertificationUpload');

        $controller->createAction($document);
    }
}
