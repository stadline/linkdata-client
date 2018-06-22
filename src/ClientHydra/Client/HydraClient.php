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
    /**
     * @throws ClientHydraException
     */
    public function doRequest(string $method, array $args)
    {
        try {
            $uriConverter = new UriConverter();
            $uri = $uriConverter->formatUri($method, $args);

            $serializator = new Serializator();
            $requester = new GuzzleAdapter();
            $body = null;
            $headers = [];

            // Put or POST, make a serialization with the entity.
            if (\in_array($uri['method'], [MethodType::POST, MethodType::PUT], true) && \count($args[1]) > 0) {
                $body = $serializator->serialize($args[1][0]);
                $headers['Content-Type'] = 'application/json';
            }

            $response = $requester->makeRequest($uri['method'], $uri['uri'], $headers, $body);

            return $serializator->deserialize($response);
        } catch (ClientHydraException $e) {
            throw $e;
        }
    }
}
