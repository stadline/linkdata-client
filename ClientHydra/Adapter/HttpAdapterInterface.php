<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Adapter;

use Stadline\LinkdataClient\ClientHydra\Exception\RequestException;

interface HttpAdapterInterface
{
    /**
     * @throws RequestException
     */
    public function makeRequest(
        string $method,
        string $uri,
        array $headers = [],
        string $body = null,
        bool $useCache = true
    ): ResponseInterface;

    public function call(Request $request, bool $useCache = true): ResponseInterface;

    public function warmupCache(array $cacheData): array;

    public function getDebugData(): array;
}
