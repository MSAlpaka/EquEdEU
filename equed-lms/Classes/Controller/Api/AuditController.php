<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Repository\AuditLogRepositoryInterface;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Controller for listing audit log entries for the authenticated user.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY) for UI labels.
 * Interacts with domain models exclusively through repository interfaces.
 */
final class AuditController extends ActionController
{
    public function __construct(
        private readonly AuditLogRepositoryInterface     $auditLogRepository,
        private readonly GptTranslationServiceInterface  $translationService,
    ) {
    }

    /**
     * Displays a list of audit log entries for the current frontend user.
     *
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function listAction(): ResponseInterface
    {
        $userContext = $this->request->getAttribute('user');
        $userId = is_array($userContext) && isset($userContext['uid'])
            ? (int)$userContext['uid']
            : 0;

        $entries = $this->auditLogRepository->findByFeUser($userId);

        $this->view->assign('entries', $entries);

        return $this->htmlResponse();
    }
}
