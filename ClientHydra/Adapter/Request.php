<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Adapter;

class Request
{
    public const CACHE_SCOPE_PUBLIC = 'public';
    public const CACHE_SCOPE_PRIVATE = 'private';

    private $method;
    private $uri;
    private $headers;
    private $body;

    private $cacheEnable = true;
    private $cacheScope = self::CACHE_SCOPE_PRIVATE;
    private $cacheScopeId = null;
    private $cacheTTL = 1;

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

    public function isCacheEnable(): bool
    {
        if (\in_array(\strtoupper($this->getMethod()), ['PUT', 'POST', 'DELETE'], true)) {
            return false;
        }

        return $this->cacheEnable;
    }

    public function setCacheEnable(bool $cacheEnable): void
    {
        $this->cacheEnable = $cacheEnable;
    }

    public function getCacheScope(): string
    {
        return $this->cacheScope;
    }

    public function setCacheScope(string $cacheScope): void
    {
        $this->cacheScope = $cacheScope;
    }

    public function getCacheScopeId(): ?string
    {
        return $this->cacheScopeId;
    }

    public function setCacheScopeId(?string $cacheScopeId): void
    {
        $this->cacheScopeId = $cacheScopeId;
    }

    public function getCacheTTL(): int
    {
        return $this->cacheTTL;
    }

    public function setCacheTTL(int $cacheTTL): void
    {
        $this->cacheTTL = $cacheTTL;
    }

    public function getCacheHash(): string
    {
        $baseStr = \json_encode($this->getMethod().'.'.$this->getUri().'.'.$this->getBody());
        if ($this->cacheScope = self::CACHE_SCOPE_PRIVATE) {
            $baseStr .= '.'.$this->cacheScopeId;
        }

        return \sha1($baseStr);
    }
}
