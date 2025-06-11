<?php

declare(strict_types=1);

namespace Equed\EquedLms\Middleware;

use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Middleware to detect and inject language for translations.
 */
final class LanguageMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly GptTranslationServiceInterface $translationService
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Try to detect language from Accept-Language header
        $acceptLanguage = $request->getHeaderLine('Accept-Language');
        $language = $this->translationService->detectLanguage($acceptLanguage)
            ?? $this->translationService->getDefaultLanguage();

        $request = $request->withAttribute('language', $language);

        return $handler->handle($request);
    }
}
// EOF
