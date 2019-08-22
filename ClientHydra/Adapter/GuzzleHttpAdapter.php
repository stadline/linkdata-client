<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Adapter;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use Psr\Cache\CacheItemPoolInterface;
use Stadline\LinkdataClient\ClientHydra\Exception\RequestException;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\CacheItem;

class GuzzleHttpAdapter implements HttpAdapterInterface
{
    private const WARMUP_CACHE_TTL = 3600;

    private $client;
    private $baseUrl;
    private $defaultHeaders = [
        'Content-Type' => 'application/ld+json',
    ];

    /** @var CacheItemPoolInterface */
    private $persistantCache;

    /**
     * Local cache for current instance only.
     *
     * @var CacheItemPoolInterface
     */
    private $executionCache;
    private $debugData;
    private $debugEnabled;

    private $isRecordingCacheWarmup = false;
    private $cacheWarmupData = [];

    public function __construct(string $baseUrl, CacheItemPoolInterface $persistantCache, $debugEnabled = false)
    {
        $this->baseUrl = $baseUrl;
        $this->client = new Client(['base_uri' => $baseUrl]);
        $this->debugEnabled = $debugEnabled;
        $this->debugData = [];
        $this->executionCache = new ArrayAdapter();

        $this->persistantCache = $persistantCache;
    }

    public function warmupCache(array $cacheData): array
    {
        try {
            $cacheKey = 'hydraclient-cache-warmup';
            if ($this->persistantCache->hasItem($cacheKey)) {
                $this->isRecordingCacheWarmup = true;
                $this->cacheWarmupData = $this->persistantCache->getItem($cacheKey)->get();
                $this->isRecordingCacheWarmup = false;
            } else {
                $this->cacheWarmupData = [];
                $this->isRecordingCacheWarmup = true;
                // get all data
                foreach ($cacheData as $i) {
                    $i['fetchData']($i['classname']);
                }
                $this->isRecordingCacheWarmup = false;
                $cacheItem = $this->persistantCache->getItem($cacheKey);
                $cacheItem->expiresAfter(self::WARMUP_CACHE_TTL);
                $cacheItem->set($this->cacheWarmupData);
                if (!$this->persistantCache->save($cacheItem)) {
                    throw new \RuntimeException('cannot save to persistantCache cache');
                }
            }

            return $this->cacheWarmupData;
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * @deprecated
     */
    public function makeRequest(
        string $method,
        string $uri,
        array $headers = [],
        string $body = null,
        bool $useCache = true
    ): ResponseInterface {
        $request = new Request($method, $uri, $headers, $body);

        return $this->call($request, $useCache);
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
                'debug' => $this->debugEnabled,
            ],
            'calls' => $this->debugData,
        ];
    }

    public function call(Request $request, bool $useCache = true): ResponseInterface
    {
        $request->setHeaders(\array_merge($this->defaultHeaders, $request->getHeaders()));
        if (\in_array(\strtoupper($request->getMethod()), ['PUT', 'POST', 'DELETE'], true)) {
            $useCache = false;
        }

        if ($this->debugEnabled) {
            $requestStartTime = \microtime(true);
            $requestData = [];
            $requestData['headers'] = $request->getHeaders();
            $requestData['body'] = $request->getBody();
            $requestData['method'] = $request->getMethod();
            $requestData['uri'] = $request->getUri();
            $requestData['cache'] = false;
            $requestData['time'] = null;
            $requestData['response'] = '?';
            $requestData['isError'] = false;
            $requestData['backtrace'] = \json_encode(\debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 20));

            $this->debugData[] = &$requestData;
        }

        /** @var \GuzzleHttp\Exception\RequestException $e */
        $e = null;

        $requestHash = $request->getCacheHash();
        if ($useCache && $this->executionCache->hasItem($requestHash)) {
            if ($this->debugEnabled) {
                $requestData['cache'] = 'execution';
            }
            $arrayResponse = $this->executionCache->getItem($requestHash)->get();
        } elseif ($useCache && $this->persistantCache->hasItem($requestHash)) {
            if ($this->debugEnabled) {
                $requestData['cache'] = 'persistant';
            }
            $arrayResponse = $this->persistantCache->getItem($requestHash)->get();

            // save in execution cache
            $cacheItem = new CacheItem();
            $cacheItem->set($this->persistantCache->getItem($requestHash)->get());
            $this->executionCache->save($cacheItem);
        } else {
            try {
                /** @var Response $response */
                $response = $this->client->send(
                    new \GuzzleHttp\Psr7\Request($request->getMethod(), $request->getUri(), $request->getHeaders(), $request->getBody())
                );
                $arrayResponse = [
                    'statusCode' => $response->getStatusCode(),
                    'body' => (string) $response->getBody(),
                    'contentType' => $response->getHeader('Content-Type')[0] ?? 'unknown',
                ];

                if ($useCache) {
                    $cacheItem = $this->executionCache->getItem($requestHash);
                    $cacheItem->set($arrayResponse);
                    if (!$this->executionCache->save($cacheItem)) {
                        throw new \RuntimeException('cannot save to execution cache');
                    }

                    if ($request->isCacheEnable()) {
                        $cacheItem = $this->persistantCache->getItem($requestHash);
                        $cacheItem->set($arrayResponse);
                        $cacheItem->expiresAfter($request->getCacheTTL());
                        if (!$this->persistantCache->save($cacheItem)) {
                            throw new \RuntimeException('cannot save to persistantCache cache');
                        }
                    }
                }
            } catch (GuzzleException $exception) {
                $e = $exception;
            }
        }

        if ($this->debugEnabled) {
            $requestEndTime = \microtime(true);
            $requestData['time'] = $requestEndTime - $requestStartTime;
            $requestData['status'] = $e ? $e->getResponse()->getStatusCode() : $arrayResponse['statusCode'];
            $requestData['response'] = $e ? $e->getResponse()->getBody()->getContents() : $arrayResponse['body'];
            $requestData['isError'] = null !== $e;
        }

        if (null !== $e) {
            // User not on available for now, create it
            if (442 === $e->getCode() && false === $this->isRecordingCacheWarmup) {
                $this->call(new Request('GET', '/v2/me'));

                return $this->call($request, $useCache);
            }

            if ($this->debugEnabled) {
                throw $e;
            }

            throw new RequestException(\sprintf('Error while requesting %s with %s method', $request->getUri(), $request->getMethod()), $request->getBody(), $e);
        }

        $contentType = $arrayResponse['contentType'];
        $contentType = \explode(';', $contentType)[0];

        if (\in_array($contentType, ['application/ld+json', 'application/json'], true)) {
            $response = new JsonResponse($arrayResponse['statusCode'], (string) $arrayResponse['body']);
        } else {
            $response = new RawResponse($arrayResponse['statusCode'], $contentType, (string) $arrayResponse['body']);
        }

        // cache warmup
        if ($this->isRecordingCacheWarmup) {
            $this->cacheWarmupData[] = $response;
        }

        return $response;
    }
}
