<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\ClientHydra\Client;

use Stadline\LinkdataClient\src\ClientHydra\Adapter\GuzzleAdapter;
use Stadline\LinkdataClient\src\ClientHydra\Exception\ClientHydraException;
use Stadline\LinkdataClient\src\ClientHydra\Type\MethodType;
use Stadline\LinkdataClient\src\ClientHydra\Utils\Serializator;
use Stadline\LinkdataClient\src\ClientHydra\Utils\UriConverter;

class HydraClient
{
    private $headers;
    private $config;

    public function __construct(array $headers = [])
    {
        $this->headers = $headers;
        $this->config = $this->loadConfiguration();
    }

    /**
     * @throws ClientHydraException
     */
    public function send(string $method, array $args): ?array
    {
        try {
            $uriConverter = new UriConverter($this->config);
            $uri = $uriConverter->formatUri($method, $args);

            $serializator = new Serializator($this->config);
            $requester = new GuzzleAdapter($this->config);
            $body = null;

            // Put or POST, make a serialization with the entity.
            if (\in_array($uri['method'], [MethodType::POST, MethodType::PUT], true) && \count($args[1]) > 0) {
                $body = $serializator->serialize($args[1][0]);
                $this->headers['Content-Type'] = 'application/json';
            }

            $response = $requester->makeRequest($uri['method'], $uri['uri'], $this->headers, $body);

            return $serializator->deserialize($response);
        } catch (ClientHydraException $e) {
            throw $e;
        }
    }

    private function loadConfiguration(): array
    {
        $json = \file_get_contents(__DIR__.'/../Config/config.json');

        return \json_decode($json, true);
    }
}
