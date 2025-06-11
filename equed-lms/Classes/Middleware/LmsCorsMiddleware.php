<?php

declare(strict_types=1);

namespace Equed\EquedLms\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * CORS middleware for EEE HoofCare LMS API.
 */
final class LmsCorsMiddleware implements MiddlewareInterface
{
    private const ALLOWED_ORIGINS = ['*'];
    private const ALLOWED_METHODS = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'];
    private const ALLOWED_HEADERS = ['Content-Type', 'Authorization', 'Accept', 'X-Requested-With'];

    /**
     * {@inheritdoc}
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Preflight request handling
        if (strtoupper($request->getMethod()) === 'OPTIONS') {
            return $this->buildPreflightResponse();
        }

        $response = $handler->handle($request);

        return $this->withCorsHeaders($response);
    }

    /**
     * Build a preflight response with CORS headers.
     */
    private function buildPreflightResponse(): ResponseInterface
    {
        $response = new \GuzzleHttp\Psr7\Response(); // PSR-7 implementation
        return $this->withCorsHeaders($response)
            ->withStatus(204);
    }

    /**
     * Injects CORS headers into response.
     */
    private function withCorsHeaders(ResponseInterface $response): ResponseInterface
    {
        $origin = $response->getHeaderLine('Origin') ?: '*';

        return $response
            ->withHeader('Access-Control-Allow-Origin', $this->selectOrigin($origin))
            ->withHeader('Access-Control-Allow-Methods', implode(', ', self::ALLOWED_METHODS))
            ->withHeader('Access-Control-Allow-Headers', implode(', ', self::ALLOWED_HEADERS))
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Vary', 'Origin');
    }

    /**
     * Choose allowed origin based on request origin.
     */
    private function selectOrigin(string $origin): string
    {
        if (in_array('*', self::ALLOWED_ORIGINS, true) || in_array($origin, self::ALLOWED_ORIGINS, true)) {
            return $origin;
        }

        return self::ALLOWED_ORIGINS[0];
    }
}
// EOF
