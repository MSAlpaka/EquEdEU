<?php

declare(strict_types=1);

namespace Equed\EquedCore\Service;

use Psr\Http\Message\ResponseInterface;

/**
 * Thin wrapper around a PSR-18 HTTP client for GPT requests.
 */
interface GptClientInterface
{
    /**
     * Send a POST request with a JSON payload.
     *
    * @param string               $url     Request URL
    * @param array<string,string> $headers HTTP headers
    * @param array<string,mixed>  $payload JSON body payload
     *
     * @return ResponseInterface HTTP response from the GPT service
     */
    public function postJson(string $url, array $headers, array $payload): ResponseInterface;
}
