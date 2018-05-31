<?php

declare(strict_types=1);

namespace Geonaute\LinkdataClient\Utils;

use Geonaute\LinkdataClient\Exception\RequestManagerException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;

abstract class GuzzleRequestManager extends Serializator
{
    private const GET = 'GET';
    private const PUT = 'PUT';
    private const POST = 'POST';
    private const DELETE = 'DELETE';

    /**
     * @throws RequestManagerException
     */
    protected function get(string $uri): string
    {
        return $this->makeRequest(self::GET, $uri);
    }

    /**
     * @throws RequestManagerException
     */
    protected function post(string $uri): string
    {
        return $this->makeRequest(self::POST, $uri);
    }

    /**
     * @throws RequestManagerException
     */
    protected function put(string $uri): string
    {
        return $this->makeRequest(self::PUT, $uri);
    }

    /**
     * @throws RequestManagerException
     */
    protected function delete(string $uri): string
    {
        return $this->makeRequest(self::DELETE, $uri);
    }

    //todo change the baseUri and place it into configuration
    private function getClient(): Client
    {
        return new Client(['base_uri' => 'http://localhost:8000/']);
    }

    /**
     * @throws RequestManagerException
     */
    private function makeRequest(string $method, string $uri): string
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
