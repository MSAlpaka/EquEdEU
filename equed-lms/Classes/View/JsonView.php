<?php

declare(strict_types=1);

namespace Equed\EquedLms\View;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\View\ResponsableViewInterface;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;

/**
 * JSON View zur standardisierten API-Ausgabe.
 */
final class JsonView implements ResponsableViewInterface
{
    private int $statusCode = 200;
    private readonly RenderingContextInterface $renderingContext;

    public function __construct(RenderingContextInterface $renderingContext)
    {
        $this->renderingContext = $renderingContext;
    }

    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    public function renderResponse(string $templateFileName = ''): ResponseInterface
    {
        $variables = $this->renderingContext->getVariableProvider()->getAll();

        $response = [
            'success' => $variables['success'] ?? true,
            'message' => $variables['message'] ?? '',
            'data'    => $variables['data'] ?? null,
        ];

        return new JsonResponse($response, $this->statusCode, ['Content-Type' => 'application/json']);
    }

}
