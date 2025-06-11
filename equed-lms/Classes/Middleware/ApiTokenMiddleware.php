<?php

declare(strict_types=1);

namespace Equed\EquedLms\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Equed\EquedLms\Service\ApiTokenService;
use Equed\EquedLms\Helper\LanguageHelper;
use Laminas\Diactoros\Response\JsonResponse;

/**
 * Middleware to authenticate API requests via Bearer token.
 */
final class ApiTokenMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly ApiTokenService $tokenService
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $token = $this->extractBearerToken($request);
        if ($token === null || !$this->tokenService->isValidToken($token)) {
            $lang    = LanguageHelper::detectLanguage($request->getServerParams());
            $message = LanguageHelper::translate('unauthorized', $lang);

            return new JsonResponse(
                ['error' => $message],
                JsonResponse::STATUS_UNAUTHORIZED
            );
        }

        return $handler->handle($request->withAttribute('apiToken', $token));
    }

    /**
     * Extracts Bearer token from Authorization header.
     */
    private function extractBearerToken(ServerRequestInterface $request): ?string
    {
        $header = $request->getHeaderLine('Authorization');
        if ($header === '' || !str_starts_with($header, 'Bearer ')) {
            return null;
        }

        $token = substr($header, 7);
        return $token !== '' ? $token : null;
    }
}
