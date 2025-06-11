<?php

declare(strict_types=1);

namespace Equed\EquedCore\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Equed\EquedCore\Domain\Model\DocumentUpload;
use Equed\EquedCore\Domain\Repository\DocumentUploadRepository;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

/**
 * Controller for document uploads.
 */
class DocumentUploadController extends ActionController
{
    private const LABEL_PATH = 'LLL:EXT:equed_core/Resources/Private/Language/locallang_db.xlf:';
    public function __construct(
        private readonly DocumentUploadRepository $documentUploadRepository,
        private readonly PersistenceManager $persistenceManager,
        private readonly LanguageService $translator
    ) {
    }

    /**
     * List all document uploads.
     *
     * @return void
     */
    public function listAction(): void
    {
        $this->view->assign('documentUploads', $this->documentUploadRepository->findAll());
    }

    /**
     * Show form for a new upload.
     *
     * @return void
     */
    public function newAction(): void
    {
    }

    /**
     * Create a new document upload.
     *
     * @param DocumentUpload $newDocument
     * @return void
     */
    public function createAction(DocumentUpload $newDocument)
    {
        $this->documentUploadRepository->add($newDocument);
        $newDocument->onCertificationUpload();
        $this->addFlashMessage(
            $this->translator->sL(self::LABEL_PATH . 'documentupload.created'),
            '',
            ContextualFeedbackSeverity::OK
        );
        $this->persistenceManager->persistAll();
        $this->redirect('list');
    }

    /**
     * Edit an existing document upload.
     *
     * @param DocumentUpload $documentUpload
     * @return void
     */
    public function editAction(DocumentUpload $documentUpload): void
    {
        $this->view->assign('documentUpload', $documentUpload);
    }

    /**
     * Update an existing document upload.
     *
     * @param DocumentUpload $documentUpload
     * @return void
     */
    public function updateAction(DocumentUpload $documentUpload)
    {
        $this->documentUploadRepository->update($documentUpload);
        $this->addFlashMessage(
            $this->translator->sL(self::LABEL_PATH . 'documentupload.updated'),
            '',
            ContextualFeedbackSeverity::OK
        );
        $this->persistenceManager->persistAll();
        $this->redirect('list');
    }

    /**
     * Delete a document upload.
     *
     * @param DocumentUpload $documentUpload
     * @return void
     */
    public function deleteAction(DocumentUpload $documentUpload)
    {
        $this->documentUploadRepository->remove($documentUpload);
        $this->addFlashMessage(
            $this->translator->sL(self::LABEL_PATH . 'documentupload.deleted'),
            '',
            ContextualFeedbackSeverity::OK
        );
        $this->persistenceManager->persistAll();
        $this->redirect('list');
    }
}
