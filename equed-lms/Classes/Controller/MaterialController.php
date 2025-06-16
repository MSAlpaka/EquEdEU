<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller;

use Equed\EquedLms\Domain\Service\MaterialListServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Controller for listing learning materials (PDF, videos) in Fluid templates.
 *
 * Utilizes hybrid live‐translation via GptTranslationServiceInterface
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 */
final class MaterialController extends ActionController
{
    public function __construct(
        private readonly MaterialListServiceInterface $listService,
    ) {
    }

    /**
     * ListAction
     *
     * @return ResponseInterface
     */
    public function listAction(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $type       = (string)($queryParams['type'] ?? '');
        $category   = (string)($queryParams['category'] ?? '');

        $data = $this->listService->getListData($type, $category);

        $this->view->assignMultiple($data);

        return $this->htmlResponse();
    }
}
