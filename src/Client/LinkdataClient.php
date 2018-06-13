<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\Client;

use HttpRequestException;
use Stadline\LinkdataClient\src\Exception\RequestManagerException;
use Stadline\LinkdataClient\src\Utils\GuzzleRequester;
use Psr\Http\Message\ResponseInterface;
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

        try {
            $requester = new GuzzleRequester();
            $response = $requester->makeRequest($uri['method'], $uri['uri']);
        } catch (RequestManagerException $e) {
            die(var_dump($e->getMessage()));
//            throw new HttpRequestException(\sprintf('Error during call url : %s with %s method', $uri['method'], $uri['uri']));
        }

        //for test
        die(var_dump($response));
    }
}
