<?php

declare(strict_types=1);

namespace Stadline\src\LinkdataClient\Utils;

use Stadline\src\LinkdataClient\Exception\RequestManagerException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;

class GuzzleRequester extends Paginator
{
    //todo change the baseUri and place it into configuration
    public function getClient(): Client
    {
        return new Client(['base_uri' => 'http://localhost:8000/']);
    }

    /**
     * @throws RequestManagerException
     */
    public function makeRequest(string $method, string $uri): string
    {
        $client = $this->getClient();
        $request = new Request($method, $uri);

        try {
            $response = $client->send($request);
        } catch (GuzzleException $e) {
            throw new RequestManagerException($e);
        }

        return $this->serialize($response->getBody());
    }
}
