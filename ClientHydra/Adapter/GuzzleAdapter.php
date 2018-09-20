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

    public function __construct(string $baseUrl)
    {
        $this->client = new Client(['base_uri' => $baseUrl]);
    }

    /**
     * @throws RequestException
     */
    public function makeRequest(string $method, string $uri, array $headers = [], string $body = null): ResponseInterface
    {
        try {
            $response = $this->client->send(
                new Request($method, $uri, $headers, $body)
            );
        } catch (GuzzleException $e) {
            throw new RequestException(\sprintf('Error while requesting %s with %s method', $uri, $method), $body, $e);
        }

        $contentType = $response->getHeader('Content-Type')[0] ?? 'unknown';

        if (\in_array($contentType, ['application/ld+json', 'application/json'])) {
            return new JsonResponse((string)$response->getBody());
        }

        return new RawResponse($contentType, (string)$response->getBody());
    }
}
