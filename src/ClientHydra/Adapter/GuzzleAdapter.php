<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\ClientHydra\Adapter;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Stadline\LinkdataClient\src\ClientHydra\Exception\RequestException\RequestException;
use Stadline\LinkdataClient\src\ClientHydra\Utils\Paginator;

class GuzzleAdapter extends Paginator
{
    public function getClient(): Client
    {
        $config = $this->loadConfiguration();

        //todo remove this, it's for development phase
        return new Client(['base_uri' => $config->base_url, 'headers' => [
            'Authorization' => 'Bearer eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJodHRwczovL2p3dC1pZHAuZXhhbXBsZS5jb20iLCJzdWIiOiJtYWlsdG86bWlrZUBleGFtcGxlLmNvbSIsIm5iZiI6MTQ4ODM3ODM4NSwiZXhwIjoxNDg4MzgxOTg1MTExMSwiaWF0IjoxNDg4Mzc4Mzg1LCJqdGkiOiJpZDEyMzQ1NiIsInR5cCI6Imh0dHBzOi8vZXhhbXBsZS5jb20vcmVnaXN0ZXIiLCJsZGlkIjoiYTA1YzUxN2YwMGJhZWFkYzI0ZmEiLCJmaXJzdG5hbWUiOiJUaG9tYXMiLCJsYXN0bmFtZSI6IkdsYWNoYW50IiwiZW1haWwiOiJ0aG9tYXNAZ2xhY2hhbnQuZnIiLCJzZXJ2ZXJUb2tlbiI6ImxkLXdvcmtlci1zZXJ2ZXItdG9rZW4ifQ.Pza4dsZYnYl8O2XCz8eiorh4ggJ1MBzT680rcQRUGBPL_b8Fxcz42HbVqv2gnGjnfjYAfk8ZBadx5OZfoafjh_zw2X7YrJMxea7OEkyKQhdTb3NeZxrHOEM-UKc5jLP0J_GHFKk3ORNAFMW6SJkTmNR5BwjUUwaSyH0gAlSCi-XI1TTdv_xheJ3YHLlCygUARsNtnQgy1a2Ws0h5bqbnMzl4VTkKgyrCjsSJeH3kA1zdm7m3V1zlY6Pi3cSpln8OcKBD1qd0pZHtrMmxubowkV_1dEQRqxRvJe3Yr1B4WkSuIXXKyVtdPJwUXXrVlVjuV1xVHrSL_UHYnMz6rYyJwKwM3jPTMvGDixpzvzT2T3nnYvPBNm-tSrrG9WSi2RWLQiR1eJNQTp9mP7nHL5nhELvwoPsqW-xzhKut6g9VgP0fQult3_XCpRgq50J4819lpeHS4GI4SUs82MZFkDjQmWT1QHP-Jdk9YqjMttLZ17zHBswidy63YdX1FejmVEY9WFp4yq4RGmt49UqCa-561w1GTM3wBpOu4tXReGHN2JLRNzmOmGlk3MzR187uXIt4IzO6TGei3StJ6xRAnRBYU8t6Yiu0nTB3le1maZv7JjOjRofKFIHuybaS9VlUoi2SoWV80KHViSjxqiYHLPuIUbXPsu__sI5PM86z1fxCYHQ',
        ]]);
    }

    /**
     * @throws RequestException
     */
    public function makeRequest(string $method, string $uri, array $headers = [], string $body = null): string
    {
        $client = $this->getClient();
        $request = new Request($method, $uri, $headers, $body);

        try {
            $response = $client->send($request);
        } catch (GuzzleException $e) {
            throw new RequestException(\sprintf('Error while requesting %s with %s method', $method, $uri), $body, $e);
        }

        return (string) $response->getBody();
    }

    private function loadConfiguration()
    {
        $json = \file_get_contents(__DIR__.'/../Config/config.json');

        return \json_decode($json);
    }
}
