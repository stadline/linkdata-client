<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Adapter;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Stadline\LinkdataClient\ClientHydra\Exception\RequestException;

class GuzzleAdapter implements AdapterInterface
{
    private $client;
    private $defaultHeaders = [
        'Content-Type' => 'application/ld+json',
    ];
    private $cache;
    private $debugData;
    private $isDebug;
    private $isDebugStoreResult;

    public function __construct(string $baseUrl, $kernelDebug)
    {
        $this->client = new Client(['base_uri' => $baseUrl]);
        $this->isDebug = $kernelDebug;
        $this->isDebugStoreResult = true;
        $this->debugData = [];
    }

    /**
     * @throws RequestException
     */
    public function makeRequest(string $method, string $uri, array $headers = [], string $body = null, bool $cacheEnable = false): ResponseInterface
    {
        $requestStartTime = \microtime(true);
        $headers = \array_merge($this->defaultHeaders, $headers);
        $requestData = [];
        $requestData['headers'] = $headers;
        $requestData['body'] = $body;

        if (\in_array(\strtoupper($method), ['PUT', 'POST', 'DELETE'], true)) {
            $cacheEnable = false;
        }

        $requestHash = \sha1(\json_encode($headers).'.'.$method.'.'.$uri.'.'.$body);
        if ($cacheEnable && isset($this->cache[$requestHash])) {
            $response = $this->cache[$requestHash];
            if ($this->isDebug) {
                $requestData['cache'] = true;
            }
        } else {
            try {
                $response = $this->client->send(
                    new Request($method, $uri, $headers, $body)
                );
                $this->cache[$requestHash] = $response;
                if ($this->isDebug) {
                    $requestData['cache'] = false;
                }
            } catch (GuzzleException $e) {
                throw new RequestException(\sprintf('Error while requesting %s with %s method', $uri, $method), $body, $e);
            }
        }

        $contentType = $response->getHeader('Content-Type')[0] ?? 'unknown';
        $contentType = \explode(';', $contentType)[0];

        if ($this->isDebug) {
            $requestEndTime = \microtime(true);
            $requestData['method'] = $method;
            $requestData['uri'] = $uri;
            $requestData['time'] = $requestEndTime - $requestStartTime;
            $requestData['response'] = $this->isDebugStoreResult ? (string) $response->getBody() : '';

            $this->debugData[] = $requestData;
        }

        if (\in_array($contentType, ['application/ld+json', 'application/json'], true)) {
            return new JsonResponse((string) $response->getBody());
        }

        return new RawResponse($contentType, (string) $response->getBody());
    }

    public function makeRequestWithCache(string $method, string $uri, array $headers = [], string $body = null): ResponseInterface
    {
        return $this->makeRequest($method, $uri, $headers, $body, true);
    }

    public function setDefaultHeader(string $key, string $value): void
    {
        $this->defaultHeaders[$key] = $value;
    }

    public function getDebugData(): array
    {
        return $this->debugData;
    }
}
