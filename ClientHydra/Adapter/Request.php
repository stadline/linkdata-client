<?php

declare(strict_types=1);

namespace SportTrackingDataSdk\ClientHydra\Adapter;

class Request
{
    public const PERSISTANTCACHE_PREFIX = 'ldclient';
    public const PERSISTANTCACHE_SCOPE_PUBLIC = 'public';
    public const PERSISTANTCACHE_SCOPE_PRIVATE = 'private';

    private $method;
    private $uri;
    private $headers;
    private $body;

    private $persistantCacheEnable = false;
    private $persistantCacheScope = self::PERSISTANTCACHE_SCOPE_PRIVATE;
    private $persistantCacheScopeId = null;
    private $persistantCacheTTL = -1;

    public function __construct(
        string $method,
        string $uri,
        array $headers = [],
        string $body = null
    ) {
        $this->method = $method;
        $this->uri = $uri;
        $this->headers = $headers;
        $this->body = $body;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function setUri(string $uri): void
    {
        $this->uri = $uri;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(?string $body): void
    {
        $this->body = $body;
    }

    public function isPersistantCacheEnable(): bool
    {
        if (false === $this->persistantCacheEnable) {
            return false;
        }

        if (null === $this->persistantCacheScope) {
            return false;
        }

        if ($this->persistantCacheTTL <= 0) {
            return false;
        }

        // @todo : remove when private scope is implemented
        if (self::PERSISTANTCACHE_SCOPE_PUBLIC !== $this->persistantCacheScope) {
            return false;
        }

        if (\in_array(\strtoupper($this->getMethod()), ['PUT', 'POST', 'DELETE'], true)) {
            return false;
        }

        return $this->persistantCacheEnable;
    }

    public function setPersistantCacheEnable(bool $persistantCacheEnable): void
    {
        $this->persistantCacheEnable = $persistantCacheEnable;
    }

    public function getPersistantCacheScope(): string
    {
        return $this->persistantCacheScope;
    }

    public function setPersistantCacheScope(string $persistantCacheScope): void
    {
        $this->persistantCacheScope = $persistantCacheScope;
    }

    public function getPersistantCacheScopeId(): ?string
    {
        return $this->persistantCacheScopeId;
    }

    public function setPersistantCacheScopeId(?string $persistantCacheScopeId): void
    {
        $this->persistantCacheScopeId = $persistantCacheScopeId;
    }

    public function getPersistantCacheTTL(): int
    {
        return $this->persistantCacheTTL;
    }

    public function setPersistantCacheTTL(int $persistantCacheTTL): void
    {
        $this->persistantCacheTTL = $persistantCacheTTL;
    }

    public function getCacheHash(): string
    {
        $baseStr = $this->getMethod().'.'.\bin2hex($this->getUri());
        if (self::PERSISTANTCACHE_SCOPE_PRIVATE === $this->persistantCacheScope) {
            $baseStr .= '.'.$this->persistantCacheScopeId;
        }

        return self::PERSISTANTCACHE_PREFIX.'.'.$baseStr;
    }
}
