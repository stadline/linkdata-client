<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Adapter;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Stadline\LinkdataClient\ClientHydra\Exception\RequestException\RequestException;

class GuzzleAdapter implements AdapterInterface
{
    private function getClient(string $baseUrl, string $authorisation): Client
    {
        return new Client(['base_uri' => $baseUrl, 'headers' => [
            'Authorization' => \sprintf('Bearer %s', $authorisation),
        ]]);
    }

    /**
     * @throws RequestException
     */
    public function makeRequest(string $method, string $baseUrl, string $uri, array $headers = [], string $body = null): string
    {
        $client = $this->getClient($baseUrl, $headers['authorization']);
        $request = new Request($method, $uri, $headers, $body);

        try {
            $response = $client->send($request);
        } catch (GuzzleException $e) {
            throw new RequestException(\sprintf('Error while requesting %s with %s method', $uri, $method), $body, $e);
        }

        return (string) $response->getBody();
    }
}
