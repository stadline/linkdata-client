<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Adapter;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Stadline\LinkdataClient\ClientHydra\Exception\RequestException;

class GuzzleAdapter implements AdapterInterface
{
    private $client;
    private $defaultHeaders = [
        'Content-Type' => 'application/ld+json',
    ];

    public function __construct(string $baseUrl)
    {
        $this->client = new Client(['base_uri' => $baseUrl]);
    }

    /**
     * @throws RequestException
     */
    public function makeRequest(string $method, string $uri, array $headers = [], string $body = null): ResponseInterface
    {
        $headers = \array_merge($this->defaultHeaders, $headers);

        try {
            $response = $this->client->send(
                new Request($method, $uri, $headers, $body)
            );
        } catch (GuzzleException $e) {
            throw new RequestException(\sprintf('Error while requesting %s with %s method', $uri, $method), $body, $e);
        }

        $contentType = $response->getHeader('Content-Type')[0] ?? 'unknown';
        $contentType = \explode(';', $contentType)[0];

        if (\in_array($contentType, ['application/ld+json', 'application/json'], true)) {
            return new JsonResponse((string) $response->getBody());
        }

        return new RawResponse($contentType, (string) $response->getBody());
    }

    public function setDefaultHeader(string $key, string $value): void
    {
        $this->defaultHeaders[$key] = $value;
    }
}
