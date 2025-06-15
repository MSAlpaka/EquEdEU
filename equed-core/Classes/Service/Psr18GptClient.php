<?php

declare(strict_types=1);

namespace Equed\EquedCore\Service;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Default implementation of {@link GptClientInterface} using PSR-18 client.
 */
final class Psr18GptClient implements GptClientInterface
{
    public function __construct(
        private readonly ClientInterface $client,
        private readonly RequestFactoryInterface $requestFactory,
        private readonly StreamFactoryInterface $streamFactory
    ) {
    }

    /**
     * {@inheritDoc}
     *
     * @return ResponseInterface Response from the HTTP client
     */
    public function postJson(string $url, array $headers, array $payload): ResponseInterface
    {
        $headers['Content-Type'] = $headers['Content-Type'] ?? 'application/json';
        $body    = $this->streamFactory->createStream(json_encode($payload, JSON_THROW_ON_ERROR));
        $request = $this->requestFactory->createRequest('POST', $url);
        foreach ($headers as $name => $value) {
            $request = $request->withHeader($name, $value);
        }
        $request = $request->withBody($body);
        return $this->client->sendRequest($request);
    }
}
