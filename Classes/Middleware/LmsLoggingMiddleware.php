<?php

declare(strict_types=1);

namespace Equed\EquedLms\Middleware;

use Equed\EquedLms\Service\LogService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Logs incoming API requests with processing duration and response status.
 */
final class LmsLoggingMiddleware implements MiddlewareInterface
{
    public function __construct(
        protected readonly LogService $logService
    ) {
    }

    /**
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $startTime = microtime(true);
        $response = $handler->handle($request);
        $durationMs = round((microtime(true) - $startTime) * 1000, 2);

        $this->logService->logInfo(
            'API request processed',
            [
                'method'      => $request->getMethod(),
                'uri'         => (string) $request->getUri(),
                'duration_ms' => $durationMs,
                'status'      => $response->getStatusCode(),
            ]
        );

        return $response;
    }
}
// EOF
