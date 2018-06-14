<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\Client;

use HttpRequestException;
use Stadline\LinkdataClient\src\Exception\RequestManagerException;
use Stadline\LinkdataClient\src\Utils\GuzzleRequester;
use Psr\Http\Message\ResponseInterface;
use Stadline\LinkdataClient\src\Utils\Serializator;
use Stadline\LinkdataClient\src\Utils\UriConverter;

/**
 * @method ResponseInterface getSports(array $options = [])
 */
class LinkdataClient
{
    public function __call(string $method, array $args)
    {
        $uriConverter = new UriConverter();
        $uri = $uriConverter->formateUri($method, $args);
        $serializator = new Serializator();


        try {
            $requester = new GuzzleRequester();
            // Put or POST, make a serialization with the entity.
            $response = $requester->makeRequest($uri['method'], $uri['uri']);

            // Deserialize and return response.
            return $serializator->deserialize($response);
        } catch (RequestManagerException $e) {
            die(var_dump($e->getMessage()));
//            throw new HttpRequestException(\sprintf('Error during call url : %s with %s method', $uri['method'], $uri['uri']));
        }
    }
}
