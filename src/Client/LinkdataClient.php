<?php

declare(strict_types=1);

namespace Stadline\src\LinkdataClient\Client;

use HttpRequestException;
use Stadline\src\LinkdataClient\Exception\RequestManagerException;
use Stadline\src\LinkdataClient\Utils\GuzzleRequester;
use Psr\Http\Message\ResponseInterface;

/**
 * @method ResponseInterface getSports(array $options = [])
 */
class LinkdataClient
{
    public function __call(string $method, array $args)
    {
        $requester = new GuzzleRequester();
        $config = $this->loadConfiguration();
        $uri = $this->uriFormater($method, $args, $config->version);

        try {
            $response = $requester->makeRequest($uri['method'], $uri['uri']);
        } catch (RequestManagerException $e) {
            throw new HttpRequestException(\sprintf('Error during call url : %s with %s method', $uri['method'], $uri['uri']));
        }

        //for test
        die(var_dump($response));

    }

    private function uriFormater(string $method, array $args, string $version): array
    {
        $response = [];

        // get each parts of method splited by uppercase
        $splitedUri = preg_split('/(?=[A-Z])/', $method, -1, PREG_SPLIT_NO_EMPTY);

        // extract the method
        $response['method'] = array_shift($splitedUri);
        // if we have an id (for querying one occurence), extract it and place it at the end of the uri
        $queryString = isset($args['id']) ? \sprintf('/%s', $args['id']) : '';

        if (1 === \count($splitedUri)) {
            $response['uri'] = \sprintf('%s/%s%s', $version, strtolower($splitedUri[0]), $queryString);

            return $response;
        }

        $uri = strtolower(array_shift($splitedUri));

        foreach ($splitedUri as $item) {
            $uri .= str_replace($item, substr($item, 0), sprintf('_%s', strtolower($item)));
        }

        $response['uri'] = \sprintf('%s/%s%s', $version, $uri, $queryString);

        return $uri;
    }

    private function loadConfiguration()
    {
        $json = file_get_contents(__DIR__.'/../Config/config.json');

        return json_decode($json);
    }
}
