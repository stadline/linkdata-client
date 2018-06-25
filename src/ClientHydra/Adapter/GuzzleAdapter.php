<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\ClientHydra\Adapter;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Stadline\LinkdataClient\src\ClientHydra\Exception\RequestException\AuthenticationException;
use Stadline\LinkdataClient\src\ClientHydra\Exception\RequestException\RequestException;

class GuzzleAdapter
{
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @throws AuthenticationException
     */
    public function getClient(array $args): Client
    {
        if (!\array_key_exists('authorization', $args['authorization'])) {
            throw new AuthenticationException('Authorization token not found.');
        }

        return new Client(['base_uri' => $this->config['base_url'], 'headers' => [
            'Authorization' => \sprintf('Bearer %s', $args['authorization']),
        ]]);
    }

    /**
     * @throws RequestException
     */
    public function makeRequest(string $method, string $uri, array $headers = [], string $body = null): string
    {
        $client = $this->getClient($headers);
        $request = new Request($method, $uri, $headers, $body);

        try {
            $response = $client->send($request);
        } catch (GuzzleException $e) {
            throw new RequestException(\sprintf('Error while requesting %s with %s method', $uri, $method), $body, $e);
        }

        return (string) $response->getBody();
    }
}
