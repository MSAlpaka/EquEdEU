<?php

declare(strict_types=1);

namespace Equed\EquedLms\Middleware;

use Equed\EquedLms\Service\TokenService;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Middleware authenticating API requests via bearer tokens and
 * injecting a simplified user array under the 'user' attribute.
 */
final class TokenUserMiddleware implements MiddlewareInterface
{
    public function __construct(private readonly TokenService $tokenService)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $token = $this->extractToken($request);
        if ($token === null) {
            return new JsonResponse(['error' => 'Missing token'], JsonResponse::STATUS_UNAUTHORIZED);
        }

        $user = $this->tokenService->validateToken($token);
        if ($user === null) {
            return new JsonResponse(['error' => 'Invalid token'], JsonResponse::STATUS_UNAUTHORIZED);
        }

        $request = $request->withAttribute('user', ['uid' => $user->getUid()]);

        return $handler->handle($request);
    }

    private function extractToken(ServerRequestInterface $request): ?string
    {
        $header = $request->getHeaderLine('Authorization');
        if ($header !== '' && str_starts_with($header, 'Bearer ')) {
            $token = substr($header, 7);
            return $token !== '' ? $token : null;
        }

        $fallback = $request->getHeaderLine('X-Api-Token');
        return $fallback !== '' ? $fallback : null;
    }
}

// EOF
