<?php

declare(strict_types=1);

namespace SportTrackingDataSdk\ClientHydra\Adapter;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Psr\Cache\CacheItemPoolInterface;
use SportTrackingDataSdk\ClientHydra\Exception\RequestException;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\CacheItem;

class GuzzleHttpAdapter implements HttpAdapterInterface
{
    private const CACHE_PREFIX = 'stdclient';
    private const CACHE_WARMUP_TTL = 3600;

    private $client;
    private $baseUrl;
    private $defaultHeaders = [
        'Content-Type' => 'application/ld+json',
    ];
    private $authorizationToken = null;

    /** @var ?CacheItemPoolInterface */
    private $persistantCache;

    /**
     * Local cache for current execution only.
     *
     * @var CacheItemPoolInterface
     */
    private $executionCache;
    private $debugData;
    private $debugEnabled;

    private $isRecordingCacheWarmup = false;
    private $cacheWarmupData = [];

    private $privatePersistentCachePrefix = '';
    private $privatePersistentCacheTtl = 300;

    public function __construct(string $baseUrl, CacheItemPoolInterface $persistantCache = null, $debugEnabled = false)
    {
        $this->baseUrl = $baseUrl;
        $this->client = new Client(['base_uri' => $baseUrl]);
        $this->debugEnabled = $debugEnabled;
        $this->debugData = [];
        $this->executionCache = new ArrayAdapter();
        $this->persistantCache = $persistantCache;
    }

    public function setPrivatePersistentCache(string $prefix, ?int $ttl): void
    {
        $this->privatePersistentCachePrefix = $prefix;
        if (null !== $ttl) {
            $this->privatePersistentCacheTtl = $ttl;
        }
    }

    public function setAuthorizationToken(string $token): void
    {
        $this->authorizationToken = $token;
    }

    public function warmupCache(array $cacheData): array
    {
        try {
            $cacheKey = Request::PERSISTANTCACHE_PREFIX.'.cache-warmup';
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
                $cacheItem->expiresAfter(self::CACHE_WARMUP_TTL);
                $cacheItem->set($this->cacheWarmupData);
                if (!$this->persistantCache->save($cacheItem)) {
                    throw new \RuntimeException('cannot save to persistantCache cache');
                }
            }

            // Add to execution cache
            foreach ($this->cacheWarmupData as $data) {
                $cacheItem = $this->executionCache->getItem($data['cachehash']);
                $cacheItem->set($data['rawresponse']);
                if (!$this->executionCache->save($cacheItem)) {
                    throw new \RuntimeException('cannot save to execution cache');
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
        bool $useExecutionCache = true
    ): ResponseInterface {
        $request = new Request($method, $uri, $headers, $body);

        return $this->call($request, $useExecutionCache);
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

    public function call(Request $request, bool $useExecutionCache = true): ResponseInterface
    {
        // if privatePersistentCache defined, give config to Request object
        if ('' !== $this->privatePersistentCachePrefix && -1 !== $this->privatePersistentCacheTtl) {
            $request->setPersistantCacheEnable(true);
            $request->setPersistantCacheScope(Request::PERSISTANTCACHE_SCOPE_PRIVATE);
            $request->setPersistantCacheScopeId($this->privatePersistentCachePrefix);
            $request->setPersistantCacheTTL($this->privatePersistentCacheTtl);
        }

        // Default header
        $request->setHeaders(\array_merge(
            $this->defaultHeaders,
            $request->getHeaders(),
            null !== $this->authorizationToken ? ['Authorization' => $this->authorizationToken] : []
        ));

        if (\in_array(\strtoupper($request->getMethod()), ['PUT', 'POST', 'DELETE'], true)) {
            $useExecutionCache = false;
        }

        if ($this->debugEnabled) {
            $requestStartTime = \microtime(true);
            $requestData = [];
            $requestData['headers'] = $request->getHeaders();
            $requestData['body'] = $request->getBody();
            $requestData['method'] = $request->getMethod();
            $requestData['uri'] = $request->getUri();
            $requestData['cacheOrigin'] = false;
            $requestData['cacheSavedIn'] = [];
            $requestData['time'] = null;
            $requestData['response'] = '?';
            $requestData['isError'] = false;
            $requestData['backtrace'] = \json_encode(\debug_backtrace(\DEBUG_BACKTRACE_IGNORE_ARGS, 20));

            $this->debugData[] = &$requestData;
        }

        /** @var null|\GuzzleHttp\Exception\RequestException $e */
        $e = null;

        $requestHash = $request->getCacheHash();
        if ($useExecutionCache && $this->executionCache->hasItem($requestHash)) {
            if ($this->debugEnabled) {
                $requestData['cacheOrigin'] = 'execution';
            }
            $arrayResponse = $this->executionCache->getItem($requestHash)->get();
        } elseif ($useExecutionCache && null !== $this->persistantCache && $this->persistantCache->hasItem($requestHash)) {
            if ($this->debugEnabled) {
                $requestData['cacheOrigin'] = 'persistant';
            }
            $arrayResponse = $this->persistantCache->getItem($requestHash)->get();

            // save in execution cache
            $cacheItem = new CacheItem();
            $cacheItem->set($this->persistantCache->getItem($requestHash)->get());
            $this->executionCache->save($cacheItem);
            $requestData['cache']['savedIn'][] = 'execution';
        } else {
            try {
                $rUri = '/' === \substr($request->getUri(), 0, 1) ? \substr($request->getUri(), 1) : $request->getUri();
                /** @var Response $response */
                $response = $this->client->send(
                    new \GuzzleHttp\Psr7\Request($request->getMethod(), $rUri, $request->getHeaders(), $request->getBody())
                );
                $arrayResponse = [
                    'statusCode' => $response->getStatusCode(),
                    'body' => (string) $response->getBody(),
                    'contentType' => $response->getHeader('Content-Type')[0] ?? 'unknown',
                ];

                if ($useExecutionCache) {
                    $cacheItem = $this->executionCache->getItem($requestHash);
                    $cacheItem->set($arrayResponse);
                    if (!$this->executionCache->save($cacheItem)) {
                        throw new \RuntimeException('cannot save to execution cache');
                    }
                    $requestData['cacheSavedIn'][] = 'execution';

                    if (null !== $this->persistantCache && $request->isPersistantCacheEnable()) {
                        $cacheItem = $this->persistantCache->getItem($requestHash);
                        $cacheItem->set($arrayResponse);
                        $cacheItem->expiresAfter($request->getPersistantCacheTTL());
                        if (!$this->persistantCache->save($cacheItem)) {
                            throw new \RuntimeException('cannot save to persistantCache cache');
                        }
                        $requestData['cacheSavedIn'][] = 'persistant';
                    }
                }
            } catch (\GuzzleHttp\Exception\RequestException $exception) {
                $e = $exception;
            }
        }

        if ($this->debugEnabled && isset($requestStartTime, $arrayResponse)) {
            $requestEndTime = \microtime(true);
            $requestData['time'] = $requestEndTime - $requestStartTime;
            $requestData['status'] = $e ? $e->getResponse()->getStatusCode() : $arrayResponse['statusCode'];
            $requestData['response'] = $e ? $e->getResponse()->getBody()->getContents() : $arrayResponse['body'];
            $requestData['isError'] = null !== $e;
            $requestData['cacheSavedIn'] = \json_encode($requestData['cacheSavedIn']);
        }

        if (null !== $e) {
            // User not on available for now, create it
            if (442 === $e->getCode() && false === $this->isRecordingCacheWarmup) {
                $this->call(new Request('GET', '/v2/me'));

                return $this->call($request, $useExecutionCache);
            }

            if ($this->debugEnabled) {
                throw $e;
            }

            throw new RequestException(\sprintf('Error while requesting %s with %s method : %s', $request->getUri(), $request->getMethod(), substr($e->getMessage(), 0, 600).'...'), $request->getBody(), $e);
        }

        if (isset($arrayResponse) && null !== $arrayResponse['contentType']) {
            $contentType = $arrayResponse['contentType'];
            $contentType = \explode(';', $contentType)[0];
        } else {
            $contentType = 'text/plain';
        }

        if (isset($arrayResponse) && \in_array($contentType, ['application/ld+json', 'application/json'], true)) {
            $response = new JsonResponse($arrayResponse['statusCode'], (string) $arrayResponse['body']);
        } else {
            if (isset($arrayResponse)) {
                $response = new RawResponse($arrayResponse['statusCode'], $contentType, (string) $arrayResponse['body']);
            } else {
                $response = new RawResponse(0, $contentType, 'no $arrayResponse available in GuzzleHttpAdapter l.238');
            }
        }

        // cache warmup
        if ($this->isRecordingCacheWarmup && isset($arrayResponse)) {
            $this->cacheWarmupData[] = [
                'cachehash' => $request->getCacheHash(),
                'rawresponse' => $arrayResponse,
                'response' => $response,
            ];
        }

        return $response;
    }

    public function getPersistantCache(): ?CacheItemPoolInterface
    {
        return $this->persistantCache;
    }
}
