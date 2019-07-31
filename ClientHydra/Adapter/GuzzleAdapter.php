<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Adapter;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Stadline\LinkdataClient\ClientHydra\Exception\RequestException;

class GuzzleAdapter implements AdapterInterface
{
    private $client;
    private $baseUrl;
    private $defaultHeaders = [
        'Content-Type' => 'application/ld+json',
    ];
    private $cache;
    private $debugData;
    private $debugEnabled;

    public function __construct(string $baseUrl, $debugEnabled = false)
    {
        $this->baseUrl = $baseUrl;
        $this->client = new Client(['base_uri' => $baseUrl]);
        $this->debugEnabled = $debugEnabled;
        $this->debugData = [];
    }

    /**
     * @throws RequestException
     */
    public function makeRequest(string $method, string $uri, array $headers = [], string $body = null, bool $cacheEnable = true): ResponseInterface
    {
        $headers = \array_merge($this->defaultHeaders, $headers);

        if ($this->debugEnabled) {
            $requestStartTime = \microtime(true);
            $requestData = [];
            $requestData['headers'] = $headers;
            $requestData['body'] = $body;
            $requestData['method'] = $method;
            $requestData['uri'] = $uri;
            $requestData['cache'] = false;
            $requestData['time'] = null;
            $requestData['response'] = '?';
            $requestData['isError'] = false;
            $requestData['backtrace'] = \json_encode(\debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 10));

            $this->debugData[] = &$requestData;
        }

        if (\in_array(\strtoupper($method), ['PUT', 'POST', 'DELETE'], true)) {
            $cacheEnable = false;
        }

        /** @var \GuzzleHttp\Exception\RequestException $e */
        $e = null;

        $requestHash = \sha1(\json_encode($headers).'.'.$method.'.'.$uri.'.'.$body);
        if ($cacheEnable && isset($this->cache[$requestHash])) {
            if ($this->debugEnabled) {
                $requestData['cache'] = true;
            }
            $response = $this->cache[$requestHash];
        } else {
            try {
                /** @var Response $response */
                $response = $this->client->send(
                    new Request($method, $uri, $headers, $body)
                );
                $this->cache[$requestHash] = $response;
            } catch (GuzzleException $exception) {
                $e = $exception;
            }
        }

        if ($this->debugEnabled) {
            $requestEndTime = \microtime(true);
            $requestData['time'] = $requestEndTime - $requestStartTime;
            $requestData['status'] = $e ? $e->getResponse()->getStatusCode() : $response->getStatusCode();
            $requestData['response'] = $e ? $e->getResponse()->getBody()->getContents() : (string) $response->getBody();
            $requestData['isError'] = $e ? true : false;
        }

        if (null !== $e) {
            // User not on available for now, create it
            if (442 === $e->getCode()) {
                $this->makeRequest('GET', '/v2/me');

                return $this->makeRequest($method, $uri, $headers, $body, $cacheEnable);
            }

            throw $e;
            throw new RequestException(\sprintf('Error while requesting %s with %s method', $uri, $method), $body, $e);
        }

        $contentType = $response->getHeader('Content-Type')[0] ?? 'unknown';
        $contentType = \explode(';', $contentType)[0];

        if (\in_array($contentType, ['application/ld+json', 'application/json'], true)) {
            return new JsonResponse($response->getStatusCode(), (string) $response->getBody());
        }

        return new RawResponse($response->getStatusCode(), $contentType, (string) $response->getBody());
    }

    public function setDefaultHeader(string $key, string $value): void
    {
        $this->defaultHeaders[$key] = $value;
    }

    public function getDebugData(): array
    {
        return [
            'config' => [
                'base_uri' => $this->baseUrl,
                'cache' => $this->cache,
                'debug' => $this->debugEnabled,
            ],
            'calls' => $this->debugData,
        ];
    }
}
